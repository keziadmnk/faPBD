<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table = 'subject';
    protected $primaryKey = 'id_subject';
    protected $allowedFields = ['nama_subject', 'passing_grade', 'jumlah_soal'];

    // Fungsi untuk mendapatkan semua mata pelajaran
    public function getAllSubjects()
    {
        return $this->findAll();  // Mengambil semua mata pelajaran
    }

    // Fungsi untuk mendapatkan mata pelajaran berdasarkan ID
    public function getSubjectById($id_subject)
    {
        return $this->find($id_subject);  // Mengambil mata pelajaran berdasarkan ID
    }
}
