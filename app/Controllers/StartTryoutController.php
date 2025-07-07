<?php

namespace App\Controllers;

use App\Models\TryoutModel;
use App\Models\QuestionModel;
use App\Models\OptionModel;
use App\Models\UserAnswerModel;
use App\Models\SubjectModel;
use App\Models\SubjectResultModel;
use App\Models\PenggunaModel;
use App\Models\TryoutPurchaseModel;

class StartTryoutController extends BaseController
{
    protected $questionModel;
    protected $optionModel;
    protected $userAnswerModel;
    protected $subjectModel;
    protected $subjectResultModel;
    protected $tryoutPurchaseModel;

    public function __construct()
    {
        $this->questionModel = new QuestionModel();
        $this->optionModel = new OptionModel();
        $this->userAnswerModel = new UserAnswerModel();
        $this->subjectModel = new SubjectModel();
        $this->subjectResultModel = new SubjectResultModel();
        $this->tryoutPurchaseModel = new TryoutPurchaseModel();
    }

    // Halaman utama pengerjaan soal
    public function index($id_tryout)
    {
        // Ambil soal berdasarkan tryout
        $questions = $this->questionModel
            ->where('id_tryout', $id_tryout)
            ->orderBy('no_soal', 'ASC')
            ->findAll();

        // Ambil informasi tryout
        $tryoutModel = new TryoutModel();
        $tryout = $tryoutModel->find($id_tryout);

        // Ambil data pengguna (dalam implementasi real, ambil dari session)
        $penggunaModel = new PenggunaModel();
        $id_pengguna = 1; // Ganti dengan session pengguna yang login
        $pengguna = $penggunaModel->find($id_pengguna);

        // Cek apakah pengguna sudah membeli tryout ini
        $purchase = $this->tryoutPurchaseModel
            ->where('id_tryout', $id_tryout)
            ->where('id_pengguna', $id_pengguna)
            ->first();

        if (!$purchase) {
            return redirect()->to('/dashboard')->with('error', 'Anda belum membeli tryout ini!');
        }

        // Cek apakah tryout sudah selesai dikerjakan
        if ($purchase['status_pengerjaan'] === 'Selesai') {
            return redirect()->to("/dashboard/user/tryout/{$id_tryout}")->with('info', 'Tryout ini sudah selesai dikerjakan!');
        }

        // Update status menjadi "Sedang Dikerjakan"
        $this->tryoutPurchaseModel->update(['id_tryout' => $id_tryout, 'id_pengguna' => $id_pengguna], [
            'status_pengerjaan' => 'Sedang Dikerjakan'
        ]);

        // Loop untuk menambahkan pilihan untuk setiap soal
        foreach ($questions as &$question) {
            // Ambil pilihan berdasarkan no_soal dari tabel detail_pertanyaan
            $question['options'] = $this->optionModel
                ->select('option.id_option, option.opsi, detail_pertanyaan.teks_option, detail_pertanyaan.point')
                ->join('detail_pertanyaan', 'detail_pertanyaan.id_option = option.id_option')
                ->where('detail_pertanyaan.no_soal', $question['no_soal'])
                ->orderBy('option.id_option', 'ASC')
                ->findAll();

            // Tentukan subject berdasarkan rentang soal
            if ($question['no_soal'] >= 1 && $question['no_soal'] <= 30) {
                $question['subject'] = 'TWK';
            } elseif ($question['no_soal'] >= 31 && $question['no_soal'] <= 65) {
                $question['subject'] = 'TIU';
            } else {
                $question['subject'] = 'TKP';
            }
        }

        // Ambil jawaban yang sudah ada (jika pengguna melanjutkan tryout)
        $existingAnswers = $this->userAnswerModel
            ->where('id_pengguna', $id_pengguna)
            ->whereIn('no_soal', array_column($questions, 'no_soal'))
            ->findAll();

        // Kirim data ke view
        return view('Tryout/Start', [
            'questions' => $questions,
            'tryout' => $tryout,
            'pengguna' => $pengguna,
            'existingAnswers' => $existingAnswers
        ]);
    }

        // Method untuk menyimpan jawaban pengguna
    public function saveAnswers()
    {
        $data = $this->request->getPost();

        // Validasi input
        if (!isset($data['id_pengguna'], $data['id_tryout'], $data['answers'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap!'
            ]);
        }

        $id_pengguna = $data['id_pengguna'];
        $id_tryout = $data['id_tryout'];
        $answers = json_decode($data['answers'], true);

        if (!$answers) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Format jawaban tidak valid!'
            ]);
        }

        try {
            // Mulai transaction untuk memastikan data konsisten
            $this->userAnswerModel->transStart();

            // Hapus jawaban lama jika ada
            $this->userAnswerModel
                ->where('id_pengguna', $id_pengguna)
                ->where('id_tryout', $id_tryout)
                ->whereIn('no_soal', array_keys($answers))
                ->delete();

            // Simpan jawaban baru
            foreach ($answers as $no_soal => $id_option) {
                $this->userAnswerModel->insert([
                    'id_pengguna' => $id_pengguna,
                    'no_soal' => $no_soal,
                    'id_option' => $id_option,
                    'id_tryout' => $id_tryout
                ]);
            }

            // Hitung hasil tryout
            $this->calculateResults($id_pengguna, $id_tryout);

            // Update status tryout menjadi selesai
            $this->tryoutPurchaseModel->update(
                ['id_tryout' => $id_tryout, 'id_pengguna' => $id_pengguna],
                ['status_pengerjaan' => 'Selesai']
            );

            $this->userAnswerModel->transComplete();

            if ($this->userAnswerModel->transStatus() === false) {
                throw new \Exception('Gagal menyimpan jawaban');
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Jawaban berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            $this->userAnswerModel->transRollback();

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    // Method untuk mengarahkan ke halaman finish

// Method untuk mengarahkan ke halaman finish
public function finish($id_tryout)
{
    // Ambil informasi tryout
    $tryoutModel = new TryoutModel();
    $tryout = $tryoutModel->find($id_tryout);

    // Ambil soal yang terkait dengan tryout ini
    $questions = $this->questionModel
        ->where('id_tryout', $id_tryout)
        ->orderBy('no_soal', 'ASC')
        ->findAll();

    // PERBAIKAN: Ambil id_pengguna dari session atau hardcode seperti di controller lain
    $penggunaModel = new PenggunaModel();
    $id_pengguna = session()->get('id_pengguna') ?? 1; // Fallback ke ID 1 jika session kosong
    
    // PERBAIKAN: Pastikan kita mendapatkan data pengguna yang lengkap
    $pengguna = $penggunaModel->find($id_pengguna);
    
    // PERBAIKAN: Validasi data pengguna
    if (!$pengguna) {
        // Jika pengguna tidak ditemukan, redirect ke dashboard dengan error
        return redirect()->to('/dashboard')->with('error', 'Data pengguna tidak ditemukan!');
    }

    // Ambil jawaban pengguna berdasarkan id_pengguna
    $userAnswerModel = new UserAnswerModel();
    $answers = $userAnswerModel->where('id_pengguna', $id_pengguna)
                                ->whereIn('no_soal', array_column($questions, 'no_soal'))
                                ->findAll();

    // Ambil hasil untuk setiap subject
    $subjectResultModel = new SubjectResultModel();
    $subjectResults = $subjectResultModel
        ->select('subject_result.*, subject.nama_subject as subject_name')
        ->join('subject', 'subject.id_subject = subject_result.id_subject')
        ->where('id_tryout', $id_tryout)
        ->where('id_pengguna', $id_pengguna) // PERBAIKAN: Tambahkan filter berdasarkan pengguna
        ->findAll();

    // PERBAIKAN: Tambahkan total_soal untuk setiap subject result
    foreach ($subjectResults as &$result) {
        switch ($result['subject_name']) {
            case 'TWK':
                $result['total_soal'] = 30;
                break;
            case 'TIU':
                $result['total_soal'] = 35;
                break;
            case 'TKP':
                $result['total_soal'] = 45;
                break;
            default:
                $result['total_soal'] = 0;
        }
    }

    // Kirim data ke halaman finish view
    return view('Tryout/Finish', [
        'tryout' => $tryout,
        'questions' => $questions,
        'pengguna' => $pengguna,  // Data pengguna lengkap dengan saldo
        'answers' => $answers,
        'subjectResults' => $subjectResults
    ]);
}




    // Menghitung hasil tryout per subject
    private function calculateResults($id_pengguna, $id_tryout)
    {
        // Ambil semua subject
        $subjects = $this->subjectModel->findAll();
        
        // Hapus hasil lama jika ada
        $this->subjectResultModel
            ->where('id_pengguna', $id_pengguna)
            ->where('id_tryout', $id_tryout)
            ->delete();

        $totalScore = 0;
        $allPassed = true;

        foreach ($subjects as $subject) {
            // Tentukan rentang soal berdasarkan subject
            switch ($subject['nama_subject']) {
                case 'TWK':
                    $startSoal = 1;
                    $endSoal = 30;
                    break;
                case 'TIU':
                    $startSoal = 31;
                    $endSoal = 65;
                    break;
                case 'TKP':
                    $startSoal = 66;
                    $endSoal = 110;
                    break;
                default:
                    continue 2;
            }

            // Hitung score untuk subject ini
            $subjectScore = 0;
            $correctCount = 0;

            for ($no_soal = $startSoal; $no_soal <= $endSoal; $no_soal++) {
                // Ambil jawaban pengguna
                $userAnswer = $this->userAnswerModel
                    ->where('id_pengguna', $id_pengguna)
                    ->where('no_soal', $no_soal)
                    ->first();

                if ($userAnswer) {
                    // Ambil point dari detail_pertanyaan
                    $detail = $this->optionModel
                        ->select('detail_pertanyaan.point')
                        ->join('detail_pertanyaan', 'detail_pertanyaan.id_option = option.id_option')
                        ->where('option.id_option', $userAnswer['id_option'])
                        ->where('detail_pertanyaan.no_soal', $no_soal)
                        ->first();

                    if ($detail) {
                        $point = $detail['point'];
                        $subjectScore += $point;
                        
                        if ($point > 0) {
                            $correctCount++;
                        }
                    }
                }
            }

            // Tentukan status kelulusan subject
            $passed = $subjectScore >= $subject['passing_grade'];
            if (!$passed) {
                $allPassed = false;
            }

            // Simpan hasil subject
            $this->subjectResultModel->insert([
                'id_pengguna' => $id_pengguna,
                'id_subject' => $subject['id_subject'],
                'id_tryout' => $id_tryout,
                'jumlah_benar' => $correctCount,
                'score' => $subjectScore,
                'status_kelulusan_subject' => $passed ? 'LULUS' : 'TIDAK LULUS'
            ]);

            $totalScore += $subjectScore;
        }

        // Update total score dan status kelulusan di tryout_purchase
        $this->tryoutPurchaseModel->update(
            ['id_tryout' => $id_tryout, 'id_pengguna' => $id_pengguna],
            [
                'total_score' => $totalScore,
                'status_kelulusan_to' => $allPassed ? 'Lulus' : 'Tidak Lulus'
            ]
        );
    }

    // API untuk mendapatkan jawaban yang sudah ada (jika diperlukan)
    public function getExistingAnswers($id_pengguna, $id_tryout)
    {
        // Ambil soal untuk tryout ini
        $questions = $this->questionModel
            ->where('id_tryout', $id_tryout)
            ->findAll();

        $questionNumbers = array_column($questions, 'no_soal');

        // Ambil jawaban yang sudah ada
       // Ambil jawaban pengguna berdasarkan id_pengguna
$answers = $this->userAnswerModel
    ->where('id_pengguna', $id_pengguna)  // Mendapatkan jawaban berdasarkan pengguna
    ->whereIn('no_soal', array_column($questions, 'no_soal'))  // Memastikan hanya jawaban untuk soal yang ada
    ->findAll();


        // Format jawaban untuk frontend
        $formattedAnswers = [];
        foreach ($answers as $answer) {
            $formattedAnswers[$answer['no_soal']] = $answer['id_option'];
        }

        return $this->response->setJSON([
            'success' => true,
            'answers' => $formattedAnswers
        ]);
    }

    // Method untuk menampilkan hasil tryout lengkap
    public function showResults($id_tryout)
    {
        // Ambil informasi tryout
        $tryoutModel = new TryoutModel();
        $tryout = $tryoutModel->find($id_tryout);

        // Ambil data pengguna
        $penggunaModel = new PenggunaModel();
        $id_pengguna = session()->get('id_pengguna') ?? 1; // Fallback ke ID 1 jika session kosong
        $pengguna = $penggunaModel->find($id_pengguna);

        // Validasi data pengguna
        if (!$pengguna) {
            return redirect()->to('/dashboard')->with('error', 'Data pengguna tidak ditemukan!');
        }

        // Ambil hasil untuk setiap subject
        $subjectResultModel = new SubjectResultModel();
        $subjectResults = $subjectResultModel
            ->select('subject_result.*, subject.nama_subject as subject_name, subject.passing_grade')
            ->join('subject', 'subject.id_subject = subject_result.id_subject')
            ->where('subject_result.id_tryout', $id_tryout)
            ->where('subject_result.id_pengguna', $id_pengguna)
            ->findAll();

        // Tambahkan total_soal untuk setiap subject result
        foreach ($subjectResults as &$result) {
            switch ($result['subject_name']) {
                case 'TWK':
                    $result['total_soal'] = 30;
                    break;
                case 'TIU':
                    $result['total_soal'] = 35;
                    break;
                case 'TKP':
                    $result['total_soal'] = 45;
                    break;
                default:
                    $result['total_soal'] = 0;
            }
        }

        // Ambil data purchase untuk mendapatkan total score dan status kelulusan
        $tryoutPurchaseModel = new TryoutPurchaseModel();
        $purchase = $tryoutPurchaseModel
            ->where('id_tryout', $id_tryout)
            ->where('id_pengguna', $id_pengguna)
            ->first();

        // Hitung total score dan status kelulusan
        $totalScore = $purchase ? $purchase['total_score'] : 0;
        $overallStatus = $purchase ? $purchase['status_kelulusan_to'] : 'Belum';

        // Simpan atau update data ke database jika belum ada
        if (!$purchase || $purchase['status_pengerjaan'] !== 'Selesai') {
            // Jika belum ada data hasil atau status belum selesai, hitung ulang
            $this->calculateResults($id_pengguna, $id_tryout);
            
            // Ambil ulang data purchase yang sudah diupdate
            $purchase = $tryoutPurchaseModel
                ->where('id_tryout', $id_tryout)
                ->where('id_pengguna', $id_pengguna)
                ->first();
            
            $totalScore = $purchase['total_score'];
            $overallStatus = $purchase['status_kelulusan_to'];
        }

        // Kirim data ke view HasilTryout
        return view('Tryout/HasilTryout', [
            'tryout' => $tryout,
            'pengguna' => $pengguna,
            'subjectResults' => $subjectResults,
            'totalScore' => $totalScore,
            'overallStatus' => $overallStatus
        ]);
    }

    
}