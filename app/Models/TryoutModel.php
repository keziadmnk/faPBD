<?php

namespace App\Models;

use CodeIgniter\Model;

class TryoutModel extends Model
{
    protected $table            = 'tryout';
    protected $primaryKey       = 'id_tryout';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_tryout', 'tanggal_mulai', 'tanggal_selesai', 'harga', 'id_kategori'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

     // Relasi kategori ke tryout
    public function getTryoutByKategori($kategoriId)
    {
        return $this->where('id_kategori', $kategoriId)->findAll();
    }

    // Menambahkan fungsi untuk mendapatkan semua tryout
    public function getAllTryout()
    {
        return $this->findAll();
    }
}
