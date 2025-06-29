<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectResultModel extends Model
{
    protected $table = 'subject_result';
    protected $primaryKey = 'id_pengguna';
    protected $allowedFields = ['id_pengguna', 'id_subject', 'id_tryout', 'jumlah_benar', 'score', 'status_kelulusan_subject'];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    // Method untuk mendapatkan hasil berdasarkan pengguna dan tryout
    public function getResultsByUserAndTryout($id_pengguna, $id_tryout)
    {
        return $this->select('subject_result.*, subject.nama_subject as subject_name, subject.passing_grade')
                    ->join('subject', 'subject.id_subject = subject_result.id_subject')
                    ->where('subject_result.id_pengguna', $id_pengguna)
                    ->where('subject_result.id_tryout', $id_tryout)
                    ->findAll();
    }

    // Method untuk mendapatkan hasil berdasarkan pengguna, tryout, dan subject
    public function getResultByUserTryoutSubject($id_pengguna, $id_tryout, $id_subject)
    {
        return $this->where('id_pengguna', $id_pengguna)
                    ->where('id_tryout', $id_tryout)
                    ->where('id_subject', $id_subject)
                    ->first();
    }
}
