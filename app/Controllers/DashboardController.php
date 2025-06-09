<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\TryoutModel;
use App\Models\TryoutPurchaseModel;
use App\Models\PenggunaModel;

class DashboardController extends BaseController
{
    public function index()
    {
        
    // Ambil data pengguna
    $penggunaModel = new PenggunaModel();
    $id_pengguna = 1;  // ID pengguna yang diinginkan (misalnya Kezia = 1)
    $pengguna = $penggunaModel->find($id_pengguna);  // Ambil data pengguna berdasarkan ID


    // Ambil data kategori dari model
    $kategoriModel = new KategoriModel();
    $kategori = $kategoriModel->getAllKategori();  // Mengambil semua kategori

    // Kirim data kategori ke view
    return view('Dashboard/Dashboard', ['kategori' => $kategori, 'pengguna' => $pengguna]);
    }
    public function tryout($kategoriId)
    {
        // Ambil data kategori
        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->getAllKategori();  // Mengambil semua kategori

        // Ambil data tryout berdasarkan kategori
        $tryoutModel = new TryoutModel();
        if ($kategoriId == 0) {
            $tryout = $tryoutModel->getAllTryout();
        } else {
            $tryout = $tryoutModel->getTryoutByKategori($kategoriId);
        }

        // ID Pengguna hardcoded (Kezia = id_pengguna 1)
        $id_pengguna = 1; 

        // Periksa status pembelian untuk setiap tryout
        $tryoutPurchaseModel = new TryoutPurchaseModel();
        foreach ($tryout as &$item) {
            $purchased = $tryoutPurchaseModel->getStatusTryout($id_pengguna, $item['id_tryout']);
            $item['is_purchased'] = $purchased ? true : false;
        }

        // Kirim data ke view
        return view('Tryout/Tryout', [
            'tryout' => $tryout,
            'kategori' => $kategori,
            'kategoriId' => $kategoriId,
            'pengguna' => $this->getUserData()  // Kirim data pengguna ke view
        ]);
    }

    // Fungsi untuk membeli tryout
    public function buyTryout($id_tryout)
{
    // Set timezone ke Asia/Jakarta
    date_default_timezone_set('Asia/Jakarta');

    // Ambil data pengguna
    $penggunaModel = new PenggunaModel();
    $id_pengguna = 1;  // ID pengguna yang membeli tryout (Kezia = 1)
    $pengguna = $penggunaModel->find($id_pengguna); // Ambil data pengguna

    // Ambil data tryout
    $tryoutModel = new TryoutModel();
    $tryout = $tryoutModel->find($id_tryout);  // Ambil data tryout berdasarkan id_tryout

    // Periksa apakah saldo cukup
    if ($pengguna['saldo'] >= $tryout['harga']) {
        // Lakukan pembelian, kurangi saldo
        $newSaldo = $pengguna['saldo'] - $tryout['harga']; 

        // Update saldo pengguna
        $penggunaModel->update($id_pengguna, ['saldo' => $newSaldo]);

        // Catat pembelian di tabel tryout_purchase
        $tryoutPurchaseModel = new TryoutPurchaseModel();
        $dataPurchase = [
            'id_tryout' => $id_tryout,
            'id_pengguna' => $id_pengguna,
            'tanggal_transaksi' => date('Y-m-d H:i:s'),
            'status_pengerjaan' => 'Belum',  // Status belum dikerjakan
            'total_score' => 0,
            'status_kelulusan_to' => 'Belum' // Status belum lulus
        ];

        // Simpan pembelian
        $tryoutPurchaseModel->save($dataPurchase);

        // Setelah pembelian berhasil, arahkan ke halaman SuccessPurchase dan tampilkan informasi pembelian
        return view('Tryout/SuccessPurchase', [
            'tryout' => $tryout,
            'tanggal_transaksi' => date('d F Y - H:i:s'),
            'harga' => $tryout['harga'],
            'pengguna' => $this->getUserData() // Pastikan data pengguna yang terbaru diteruskan ke view
        ]);
    } else {
        // Jika saldo tidak cukup
        return redirect()->back()->with('error', 'Saldo Anda tidak mencukupi untuk membeli tryout.');
    }
}


public function tryoutPurchase($status = 'Belum')
{
    $id_pengguna = 1;  // ID Pengguna hardcoded ( Kezia = id_pengguna 1)

    // Ambil data tryout purchase berdasarkan ID pengguna dan status pengerjaan
    $tryoutPurchaseModel = new TryoutPurchaseModel();
    $tryoutPurchases = $tryoutPurchaseModel->getByUserIdAndStatus($id_pengguna, $status);

    // Ambil data pengguna
    $penggunaModel = new PenggunaModel();
    $pengguna = $penggunaModel->find($id_pengguna); // Ambil data pengguna

    // Kirim data ke view, termasuk data pengguna
    return view('Tryout/Tryout_Purchase', [
        'tryoutPurchases' => $tryoutPurchases,
        'status' => $status,
        'pengguna' => $pengguna  // Pastikan data pengguna diteruskan ke view
    ]);
}

    public function userTryout()
{
    $id_pengguna = 1;  // ID Pengguna hardcoded ( Kezia = id_pengguna 1)

    // Ambil data tryout purchase berdasarkan ID pengguna
    $tryoutPurchaseModel = new TryoutPurchaseModel();
    $tryoutPurchasesBelum = $tryoutPurchaseModel->getByUserIdAndStatus($id_pengguna, 'Belum');
    $tryoutPurchasesSelesai = $tryoutPurchaseModel->getByUserIdAndStatus($id_pengguna, 'Selesai');

    // Ambil data pengguna
    $penggunaModel = new PenggunaModel();
    $pengguna = $penggunaModel->find($id_pengguna); // Ambil data pengguna

    // Kirim data ke view, termasuk data pengguna dan tryout yang sudah dan belum dikerjakan
    return view('Tryout/UserTryout', [
        'tryoutPurchasesBelum' => $tryoutPurchasesBelum,
        'tryoutPurchasesSelesai' => $tryoutPurchasesSelesai,
        'pengguna' => $pengguna  // Pastikan data pengguna diteruskan ke view
    ]);
}

   public function attention($id_tryout)
{
    // Ambil data pengguna
    $id_pengguna = 1; // ID Pengguna hardcoded (misal Kezia = id_pengguna 1)
    $penggunaModel = new PenggunaModel();
    $pengguna = $penggunaModel->find($id_pengguna);

    // Ambil data tryout berdasarkan id_tryout
    $tryoutModel = new TryoutModel();
    $tryout = $tryoutModel->find($id_tryout);

    // Kirim data ke view Attention
    return view('Tryout/Attention', [
        'tryout' => $tryout,
        'pengguna' => $pengguna
    ]);
}


    public function startTryout($id_tryout)
{
    // Ambil data tryout
    $tryoutModel = new TryoutModel();
    $tryout = $tryoutModel->find($id_tryout);

    // Ambil data pengguna
    $penggunaModel = new PenggunaModel();
    $id_pengguna = 1; // Misalnya ID pengguna 1
    $pengguna = $penggunaModel->find($id_pengguna);

    // Kirim data ke halaman ujian (start tryout)
    return view('Tryout/Start', [
        'tryout' => $tryout,
        'pengguna' => $pengguna
    ]);
}

  
    // Method untuk mengubah status pengerjaan tryout ke 'Selesai'
    public function completeTryout($id_purchase)
    {
        $tryoutPurchaseModel = new TryoutPurchaseModel();

        // Mengupdate status pengerjaan menjadi 'Selesai'
        $data = [
            'status_pengerjaan' => 'Selesai'
        ];

        // Update data di database berdasarkan id_purchase
        $tryoutPurchaseModel->update($id_purchase, $data);

        // Redirect kembali ke halaman tryout yang sudah dikerjakan
        return redirect()->to('/dashboard/tryout_purchase/Selesai');
    }

    public function help()
{
    // Ambil data pengguna
    $pengguna = $this->getUserData();  // Pastikan ini mengambil data pengguna yang benar

    // Menampilkan halaman Help dan mengirimkan data pengguna
    return view('Help/Help', [
        'pengguna' => $pengguna  // Kirim data pengguna ke view
    ]);
}
    public function account()
{
    // Ambil data pengguna
    $pengguna = $this->getUserData();  // Pastikan ini mengambil data pengguna yang benar

    // Menampilkan halaman Account dan mengirimkan data pengguna
    return view('Setting/Account', [
        'pengguna' => $pengguna  // Kirim data pengguna ke view
    ]);
}

public function security()
{
    // Ambil data pengguna
    $pengguna = $this->getUserData();  // Pastikan ini mengambil data pengguna yang benar

    // Menampilkan halaman Security dan mengirimkan data pengguna
    return view('Setting/Security', [
        'pengguna' => $pengguna  // Kirim data pengguna ke view
    ]);
}


 
     private function getUserData()
    {
        // Ambil data pengguna dari model
        $penggunaModel = new PenggunaModel();
        $id_pengguna = 1;  // ID pengguna yang diinginkan (misalnya Kezia = 1)
        return $penggunaModel->find($id_pengguna);
    }

}
