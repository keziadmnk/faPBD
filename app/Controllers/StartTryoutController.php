<?php

namespace App\Controllers;

use App\Models\TryoutModel;
use App\Models\QuestionModel;
use App\Models\OptionModel;
use App\Models\UserAnswerModel;
use App\Models\SubjectModel;
use App\Models\SubjectResultModel;

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
   public function index($id_tryout)
{
    // Ambil soal berdasarkan tryout
    $questions = $this->questionModel
        ->where('id_tryout', $id_tryout)
        ->findAll();

    // Ambil informasi tryout
    $tryoutModel = new TryoutModel();
    $tryout = $tryoutModel->find($id_tryout);

    // Kirim data ke view
    return view('Tryout/Start', [
        'questions' => $questions,  
        'tryout' => $tryout
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
        // Logika untuk menghitung jumlah soal yang benar dan hasil akhir
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

                // Update nilai atau logika lulus
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
