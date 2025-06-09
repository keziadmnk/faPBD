<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPertanyaanModel extends Model
{
    protected $table = 'detail_pertanyaan';
    protected $primaryKey = 'no_soal';
    protected $allowedFields = ['no_soal', 'id_option', 'teks_option', 'point'];

    // Fungsi untuk mendapatkan semua detail pertanyaan berdasarkan nomor soal
    public function getDetailByQuestion($no_soal)
    {
        return $this->where('no_soal', $no_soal)->findAll();  // Mengambil semua detail berdasarkan soal
    }
}
