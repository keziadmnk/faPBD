<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAnswerModel extends Model
{
    protected $table = 'user_answer';
    protected $primaryKey = 'id_pengguna';
    protected $allowedFields = ['id_pengguna', 'no_soal', 'id_option'];

    // Menyimpan jawaban
    public function saveAnswer($data)
    {
        return $this->insert($data);
    }
}
