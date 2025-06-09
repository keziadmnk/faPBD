<?php
namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table = 'question';
    protected $primaryKey = 'no_soal';
    protected $allowedFields = ['id_tryout', 'id_subject', 'teks_soal', 'penjelasan'];

    // Relasi ke opsi soal
    public function getOptions($no_soal)
    {
        return $this->db->table('detail_pertanyaan')
            ->join('option', 'option.id_option = detail_pertanyaan.id_option')
            ->where('detail_pertanyaan.no_soal', $no_soal)
            ->get()->getResultArray();
    }
}
