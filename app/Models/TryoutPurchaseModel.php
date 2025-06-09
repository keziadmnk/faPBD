<?php

namespace App\Models;

use CodeIgniter\Model;

class TryoutPurchaseModel extends Model
{
    protected $table            = 'tryout_purchase';
    protected $primaryKey       = 'id_tryout';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_tryout', 'id_pengguna', 'tanggal_transaksi', 'status_pengerjaan', 'total_score', 'status_kelulusan_to'];


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

     public function getByUserId($id_pengguna)
    {
        return $this->where('id_pengguna', $id_pengguna)->findAll();
    }

    public function getByTryoutId($id_tryout)
    {
        return $this->where('id_tryout', $id_tryout)->findAll();
    }

    // NEW METHOD: Get status of tryout purchase for a user
    public function getStatusTryout($id_pengguna, $id_tryout)
    {
        return $this->where('id_pengguna', $id_pengguna)
                    ->where('id_tryout', $id_tryout)
                    ->first(); // Returns the first matching record or null if not found
    }
    // Override save method to handle composite primary key insert
    public function savePurchase($data)
    {
        // Ensure that the primary key (composite) is provided in the insert
        if (!isset($data['id_tryout']) || !isset($data['id_pengguna'])) {
            throw new \Exception('id_tryout and id_pengguna must be provided.');
        }

        return $this->insert($data);
    }
    public function getByUserIdAndStatus($id_pengguna, $status)
    {
        return $this->select('tryout_purchase.*, tryout.nama_tryout, tryout.tanggal_mulai, tryout.tanggal_selesai')
                    ->join('tryout', 'tryout.id_tryout = tryout_purchase.id_tryout')
                    ->where('id_pengguna', $id_pengguna)
                    ->where('status_pengerjaan', $status)
                    ->findAll();
    }
}
