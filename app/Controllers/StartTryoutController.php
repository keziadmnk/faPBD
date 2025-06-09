<?php

namespace App\Controllers;

use App\Models\TryoutModel;
use App\Models\QuestionModel;
use App\Models\OptionModel;
use App\Models\UserAnswerModel;
use App\Models\SubjectModel;
use App\Models\SubjectResultModel;
use App\Models\PenggunaModel;

class StartTryoutController extends BaseController
{
    protected $questionModel;
    protected $optionModel;
    protected $userAnswerModel;
    protected $subjectModel;
    protected $subjectResultModel;

    public function __construct()
    {
        $this->questionModel = new QuestionModel();
        $this->optionModel = new OptionModel();
        $this->userAnswerModel = new UserAnswerModel();
        $this->subjectModel = new SubjectModel();
        $this->subjectResultModel = new SubjectResultModel();
    }

    // Halaman utama pengerjaan soal
    // Controller StartTryoutController.php
// Controller: StartTryoutController.php
public function index($id_tryout)
{
    // Ambil soal berdasarkan tryout
    $questions = $this->questionModel
        ->where('id_tryout', $id_tryout)
        ->findAll();

    // Ambil informasi tryout
    $tryoutModel = new TryoutModel();
    $tryout = $tryoutModel->find($id_tryout);

    // Ambil data pengguna
    $penggunaModel = new PenggunaModel();
    $id_pengguna = 1; // Misalnya ID pengguna 1
    $pengguna = $penggunaModel->find($id_pengguna); // Ambil data pengguna berdasarkan ID

    // Ambil nama subject untuk soal berdasarkan rentang soal
    $subjectModel = new SubjectModel();
    $subjects = $subjectModel->findAll(); // Ambil semua subject (TWK, TIU, TKP)

    // Loop untuk menambahkan pilihan untuk setiap soal
    foreach ($questions as &$question) {
        // Ambil pilihan berdasarkan no_soal
        $question['options'] = $this->optionModel
            ->join('detail_pertanyaan', 'detail_pertanyaan.id_option = option.id_option')
            ->where('detail_pertanyaan.no_soal', $question['no_soal'])
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

    // Kirim data ke view
    return view('Tryout/Start', [
        'questions' => $questions,  // Pastikan variabel questions ada
        'tryout' => $tryout,
        'pengguna' => $pengguna,    // Pastikan variabel pengguna diteruskan ke view
        'subjects' => $subjects    // Menambahkan data subject untuk ditampilkan
    ]);
}


    // Menyimpan jawaban pengguna
    public function saveAnswer()
    {
        $data = $this->request->getPost(); // Mendapatkan data yang dikirimkan via POST

        // Validasi jawaban pengguna
        if (isset($data['id_pengguna'], $data['no_soal'], $data['id_option'])) {
            // Simpan jawaban ke dalam database
            $this->userAnswerModel->saveAnswer($data);

            return redirect()->to('/dashboard/start_tryout/' . $data['id_tryout']);
        }

        return redirect()->back()->with('error', 'Jawaban tidak lengkap!');
    }

    // Menyelesaikan tryout dan menghitung hasil
    public function finishTryout($id_pengguna, $id_tryout)
    {
        // Hitung hasil tryout
        $questions = $this->questionModel->where('id_tryout', $id_tryout)->findAll();
        $correctAnswers = 0;
        $totalScore = 0;

        foreach ($questions as $question) {
            $userAnswer = $this->userAnswerModel
                ->where('id_pengguna', $id_pengguna)
                ->where('no_soal', $question['no_soal'])
                ->first();

            if ($userAnswer) {
                $correctAnswer = $this->optionModel->find($userAnswer['id_option']);
                $detailPertanyaan = $this->optionModel->find($question['no_soal']);

                if ($correctAnswer['point'] > 0) {
                    $correctAnswers++;
                }
            }
        }

        // Simpan hasil ke dalam subject_result
        $subjectResultModel = new SubjectResultModel();
        $subjectResultModel->save([ 
            'id_pengguna' => $id_pengguna,
            'id_tryout' => $id_tryout,
            'jumlah_benar' => $correctAnswers,
            'score' => $totalScore,
            'status_kelulusan_subject' => $totalScore >= 75 ? 'LULUS' : 'TIDAK LULUS'
        ]);

        return redirect()->to('/dashboard/user/tryout/' . $id_tryout);
    }
}
