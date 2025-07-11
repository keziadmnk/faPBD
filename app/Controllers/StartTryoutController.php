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
        $id_pengguna = session()->get('pengguna')['id_pengguna'];
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
        $db = \Config\Database::connect();
        $db->table('tryout_purchase')
            ->where('id_tryout', $id_tryout)
            ->where('id_pengguna', $id_pengguna)
            ->update(['status_pengerjaan' => 'Sedang Dikerjakan']);

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
            ->where('id_tryout', $id_tryout)
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
        log_message('debug', 'Data POST: ' . json_encode($data));

        // Validasi input
        if (!isset($data['id_pengguna'], $data['id_tryout'], $data['answers'])) {
            log_message('debug', 'Data tidak lengkap!');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap!'
            ]);
        }

        $id_pengguna = $data['id_pengguna'];
        $id_tryout = $data['id_tryout'];
        $answers = json_decode($data['answers'], true);
        log_message('debug', 'Answers decoded: ' . json_encode($answers));

        if (!$answers) {
            log_message('debug', 'Format jawaban tidak valid!');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Format jawaban tidak valid!'
            ]);
        }

        try {
            // Validasi: pastikan semua id_option dan no_soal valid
            $valid = true;
            foreach ($answers as $no_soal => $id_option) {
                $soal = $this->questionModel->where('no_soal', $no_soal)->first();
                $opsi = $this->optionModel->where('id_option', $id_option)->first();
                if (!$soal || !$opsi) {
                    $valid = false;
                    break;
                }
            }
            if (!$valid) {
                log_message('debug', 'Ada jawaban dengan soal atau opsi tidak valid!');
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ada jawaban dengan soal atau opsi tidak valid!'
                ]);
            }

            // Mulai transaction untuk memastikan data konsisten
            log_message('debug', 'Mulai hapus jawaban lama...');
            // Hapus jawaban lama untuk user dan tryout ini
            $this->userAnswerModel
                ->where('id_pengguna', $id_pengguna)
                ->where('id_tryout', $id_tryout)
                ->delete();
            log_message('debug', 'Cek data user_answer setelah delete: ' . json_encode(
                $this->userAnswerModel
                    ->where('id_pengguna', $id_pengguna)
                    ->where('id_tryout', $id_tryout)
                    ->findAll()
            ));
            log_message('debug', 'Hapus jawaban lama selesai. Mulai insert jawaban baru...');
            // Simpan jawaban baru
            $db = \Config\Database::connect();
            foreach ($answers as $no_soal => $id_option) {
                log_message('debug', 'Insert user_answer: ' . json_encode([
                    'id_pengguna' => $id_pengguna,
                    'no_soal' => $no_soal,
                    'id_tryout' => $id_tryout,
                    'id_option' => $id_option
                ]));
                $result = $db->table('user_answer')->insert([
                    'id_pengguna' => $id_pengguna,
                    'no_soal' => $no_soal,
                    'id_tryout' => $id_tryout,
                    'id_option' => $id_option
                ]);
                $error = $db->error();
                log_message('debug', 'Insert result: ' . json_encode($result) . ' | Error: ' . json_encode($error));
                if (!$result) {
                    log_message('error', 'Insert user_answer gagal: ' . json_encode($error));
                    throw new \Exception('Insert user_answer gagal: ' . $error['message']);
                }
            }
            log_message('debug', 'Insert jawaban baru selesai.');

            // Hitung hasil tryout
            $this->calculateResults($id_pengguna, $id_tryout);

            // Update status tryout menjadi selesai
            $db = \Config\Database::connect();
            $db->table('tryout_purchase')
                ->where('id_tryout', $id_tryout)
                ->where('id_pengguna', $id_pengguna)
                ->update(['status_pengerjaan' => 'Selesai']);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Jawaban berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Gagal simpan jawaban: ' . $e->getMessage() . ' | Data: ' . json_encode($data));
            $this->userAnswerModel->transRollback();

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage() // tampilkan pesan error asli
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
    $id_pengguna = session()->get('pengguna')['id_pengguna']; // Fallback ke ID 1 jika session kosong
    
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
                                ->where('id_tryout', $id_tryout)
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

    public function reviewSubject($id_tryout, $id_subject)
    {
        $id_pengguna = session()->get('pengguna')['id_pengguna'];
        $questionModel = new \App\Models\QuestionModel();
        $detailPertanyaanModel = new \App\Models\DetailPertanyaanModel();
        $optionModel = new \App\Models\OptionModel();
        $userAnswerModel = new \App\Models\UserAnswerModel();
        $subjectModel = new \App\Models\SubjectModel();
        $tryoutModel = new \App\Models\TryoutModel();

        $subject = $subjectModel->find($id_subject);
        $tryout = $tryoutModel->find($id_tryout);

        // Ambil semua soal untuk tryout dan subject ini
        $questions = $questionModel->where('id_tryout', $id_tryout)
                                   ->where('id_subject', $id_subject)
                                   ->orderBy('no_soal', 'ASC')
                                   ->findAll();
        // Ambil semua jawaban user untuk tryout ini
        $userAnswers = $userAnswerModel->where('id_pengguna', $id_pengguna)
                                       ->where('id_tryout', $id_tryout)
                                       ->findAll();
        $userAnswerMap = [];
        foreach ($userAnswers as $ua) {
            $userAnswerMap[$ua['no_soal']] = $ua['id_option'];
        }
        // Untuk setiap soal, ambil opsi dan point
        foreach ($questions as &$q) {
            $q['options'] = $detailPertanyaanModel->where('no_soal', $q['no_soal'])->orderBy('id_option','ASC')->findAll();
            // Ambil jawaban user untuk soal ini
            $q['user_answer'] = $userAnswerMap[$q['no_soal']] ?? null;
            // Cari id_option yang benar (point tertinggi)
            $q['correct_option'] = null;
            $max_point = -9999;
            foreach ($q['options'] as $opt) {
                if ($opt['point'] > $max_point) {
                    $max_point = $opt['point'];
                    $q['correct_option'] = $opt['id_option'];
                }
            }
        }
        $pengguna = session()->get('pengguna');
        return view('Tryout/ReviewSubject', [
            'questions' => $questions,
            'subject' => $subject,
            'tryout' => $tryout,
            'pengguna' => $pengguna
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
            // Ambil semua soal untuk tryout dan subject ini
            $questions = $this->questionModel
                ->where('id_tryout', $id_tryout)
                ->where('id_subject', $subject['id_subject'])
                ->findAll();

            $subjectScore = 0;
            $correctCount = 0;

            foreach ($questions as $q) {
                $no_soal = $q['no_soal'];
                // Ambil jawaban pengguna
                $userAnswer = $this->userAnswerModel
                    ->where('id_pengguna', $id_pengguna)
                    ->where('no_soal', $no_soal)
                    ->where('id_tryout', $id_tryout)
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
        $db = \Config\Database::connect();
        $db->table('tryout_purchase')
            ->where('id_tryout', $id_tryout)
            ->where('id_pengguna', $id_pengguna)
            ->update([
                'total_score' => $totalScore,
                'status_kelulusan_to' => $allPassed ? 'Lulus' : 'Tidak Lulus'
            ]);
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
        $answers = $this->userAnswerModel
            ->where('id_pengguna', $id_pengguna)
            ->where('id_tryout', $id_tryout)
            ->whereIn('no_soal', $questionNumbers)
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
        $id_pengguna = session()->get('pengguna')['id_pengguna']; // Fallback ke ID 1 jika session kosong
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