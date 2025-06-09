<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectResultModel extends Model
{
    protected $table = 'subject_result';
    protected $primaryKey = 'id_pengguna';
    protected $allowedFields = ['id_pengguna', 'id_subject', 'id_tryout', 'jumlah_benar', 'score', 'status_kelulusan_subject'];
}
