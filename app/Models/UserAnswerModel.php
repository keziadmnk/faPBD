<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAnswerModel extends Model
{
    protected $table = 'user_answer';
    protected $allowedFields = ['id_pengguna', 'no_soal', 'id_tryout', 'id_option'];

    // Menyimpan jawaban
    public function saveAnswer($data)
    {
        return $this->insert($data);
    }
}
