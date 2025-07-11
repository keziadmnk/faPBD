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
    $id_pengguna = session()->get('pengguna')['id_pengguna'];
    $penggunaModel = new \App\Models\PenggunaModel();
    $pengguna = $penggunaModel->find($id_pengguna);
    session()->set('pengguna', $pengguna); 


    // Ambil data kategori dari model
    $kategoriModel = new KategoriModel();
    $kategori = $kategoriModel->getAllKategori();  

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
        $id_pengguna = session()->get('pengguna')['id_pengguna']; 

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
            'pengguna' => session()->get('pengguna')  // Kirim data pengguna ke view
        ]);
    }

    // Fungsi untuk membeli tryout
    public function buyTryout($id_tryout)
{
    // Set timezone ke Asia/Jakarta
    date_default_timezone_set('Asia/Jakarta');

    // Ambil data pengguna
    $penggunaModel = new PenggunaModel();
    $id_pengguna = session()->get('pengguna')['id_pengguna'];  // ID pengguna yang membeli tryout (Kezia = 1)
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
        $db = \Config\Database::connect();
        $db->table('tryout_purchase')->insert($dataPurchase);

        // Update session dengan saldo terbaru
        $pengguna = $penggunaModel->find($id_pengguna);
        session()->set('pengguna', $pengguna);

        // Tampilkan halaman sukses pembelian
        return view('Tryout/SuccessPurchase', [
            'tryout' => $tryout,
            'tanggal_transaksi' => date('d F Y - H:i:s'),
            'harga' => $tryout['harga'],
            'pengguna' => $pengguna // Pastikan data pengguna yang terbaru diteruskan ke view
        ]);
    } else {
        // Jika saldo tidak cukup
        return redirect()->back()->with('error', 'Saldo Anda tidak mencukupi untuk membeli tryout.');
    }
}


public function tryoutPurchase($status = 'Belum')
{
    $id_pengguna = session()->get('pengguna')['id_pengguna'];  // ID Pengguna hardcoded ( Kezia = id_pengguna 1)

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
    $id_pengguna = session()->get('pengguna')['id_pengguna'];  // ID Pengguna hardcoded ( Kezia = id_pengguna 1)

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
    $id_pengguna = session()->get('pengguna')['id_pengguna']; // ID Pengguna hardcoded (misal Kezia = id_pengguna 1)
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
    $id_pengguna = session()->get('pengguna')['id_pengguna']; // Misalnya ID pengguna 1
    $pengguna = $penggunaModel->find($id_pengguna);

    // Kirim data ke halaman ujian (start tryout)
    return view('Tryout/Start', [
        'tryout' => $tryout,
        'pengguna' => $pengguna
    ]);
}

  
    // Method untuk mengubah status pengerjaan tryout ke 'Selesai'
    public function completeTryout($id_tryout)
    {
        $tryoutPurchaseModel = new TryoutPurchaseModel();
        $id_pengguna = session()->get('pengguna')['id_pengguna'];
        $data = [
            'status_pengerjaan' => 'Selesai'
        ];
        // Update data di database berdasarkan composite key
        $db = \Config\Database::connect();
        $db->table('tryout_purchase')
            ->where('id_tryout', $id_tryout)
            ->where('id_pengguna', $id_pengguna)
            ->update($data);
        // Redirect kembali ke halaman tryout yang sudah dikerjakan
        return redirect()->to('/dashboard/tryout_purchase/Selesai');
    }

    public function help()
{
    // Ambil data pengguna terbaru dari session
    $pengguna = session()->get('pengguna');
    return view('Help/Help', ['pengguna' => $pengguna]);
}
    public function account()
{
    // Ambil data pengguna terbaru dari session
    $pengguna = session()->get('pengguna');
    return view('Setting/Account', ['pengguna' => $pengguna]);
}

public function security()
{
    // Ambil data pengguna terbaru dari session
    $pengguna = session()->get('pengguna');
    return view('Setting/Security', ['pengguna' => $pengguna]);
}

public function editAccount()
{
    $penggunaModel = new \App\Models\PenggunaModel();
    $id_pengguna = session()->get('pengguna')['id_pengguna'];
    // Fallback: jika ada data POST, tetap proses update meski method bukan 'post'
    if ($this->request->getMethod() === 'post' || !empty($this->request->getPost())) {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'provinsi' => $this->request->getPost('provinsi'),
            'kabupaten' => $this->request->getPost('kabupaten'),
        ];
        $result = $penggunaModel->update($id_pengguna, $data);
        if (!$result) {
            $error = $penggunaModel->errors();
            return redirect()->back()->withInput()->with('error', 'Gagal update: ' . json_encode($error));
        }
        // Ambil data terbaru dan update session
        $pengguna = $penggunaModel->find($id_pengguna);
        session()->set('pengguna', $pengguna);
        return redirect()->to('/dashboard/account')->with('success', 'Data akun berhasil diperbarui!');
    }
    $pengguna = $penggunaModel->find($id_pengguna);
    return view('Setting/EditAccount', ['pengguna' => $pengguna]);
}


 
     private function getUserData()
    {
        // Ambil data pengguna dari model
        $penggunaModel = new PenggunaModel();
        $id_pengguna = session()->get('pengguna')['id_pengguna'];  // ID pengguna yang diinginkan (misalnya Kezia = 1)
        return $penggunaModel->find($id_pengguna);
    }

    public function topuphistory()
{
    // Ambil data pengguna terbaru dari session
    $pengguna = session()->get('pengguna');
    return view('Payment/TopUpHistory', ['pengguna' => $pengguna]);
}

public function voucherhistory()
{
    $id_pengguna = session()->get('pengguna')['id_pengguna'];
    $pengguna = session()->get('pengguna');
    $db = \Config\Database::connect();
    $histori = $db->table('redeem_voucher')->where('id_pengguna', $id_pengguna)->orderBy('tanggal_digunakan', 'desc')->get()->getResultArray();
    return view('Payment/VoucherHistory', [
        'pengguna' => $pengguna,
        'histori' => $histori
    ]);
}

public function tryouthistory()
{
    $id_pengguna = session()->get('pengguna')['id_pengguna'];
    $pengguna = session()->get('pengguna');
    $db = \Config\Database::connect();
    $histori = $db->table('tryout_purchase')
        ->select('tryout_purchase.*, tryout.nama_tryout, tryout.harga')
        ->join('tryout', 'tryout.id_tryout = tryout_purchase.id_tryout')
        ->where('tryout_purchase.id_pengguna', $id_pengguna)
        ->orderBy('tryout_purchase.tanggal_transaksi', 'desc')
        ->get()->getResultArray();
    return view('Payment/TryoutHistory', [
        'pengguna' => $pengguna,
        'histori' => $histori
    ]);
}

// Method untuk menampilkan hasil tryout (redirect ke StartTryoutController)
    public function viewTryoutResults($id_tryout)
    {
        // Redirect ke StartTryoutController untuk menampilkan hasil
        return redirect()->to("/dashboard/user/tryout/{$id_tryout}/results");
    }

public function voucherDetail($kode_voucher)
{
    $id_pengguna = session()->get('pengguna')['id_pengguna'];
    $db = \Config\Database::connect();
    $voucher = $db->table('redeem_voucher')
        ->where('kode_voucher', $kode_voucher)
        ->where('id_pengguna', $id_pengguna)
        ->get()->getRowArray();
    if (!$voucher) {
        return redirect()->to('/dashboard/user/voucherhistory')->with('error', 'Voucher tidak ditemukan atau bukan milik Anda.');
    }
    $pengguna = session()->get('pengguna');
    return view('TopUp/DetailRedeem', [
        'pengguna' => $pengguna,
        'voucher' => $voucher
    ]);
}

public function tryoutHistoryDetail($id_tryout)
{
    $id_pengguna = session()->get('pengguna')['id_pengguna'];
    $db = \Config\Database::connect();
    $purchase = $db->table('tryout_purchase')
        ->where('id_tryout', $id_tryout)
        ->where('id_pengguna', $id_pengguna)
        ->get()->getRowArray();
    if (!$purchase) {
        return redirect()->to('/dashboard/user/tryouthistory')->with('error', 'Data tryout tidak ditemukan atau bukan milik Anda.');
    }
    $tryout = $db->table('tryout')->where('id_tryout', $id_tryout)->get()->getRowArray();
    $pengguna = session()->get('pengguna');
    return view('Tryout/SuccessPurchase', [
        'tryout' => $tryout,
        'tanggal_transaksi' => $purchase['tanggal_transaksi'],
        'harga' => $tryout['harga'] ?? 0,
        'pengguna' => $pengguna
    ]);
}

public function raport()
{
    $id_pengguna = session()->get('pengguna')['id_pengguna'];
    $pengguna = session()->get('pengguna');
    $db = \Config\Database::connect();
    
    // Ambil semua tryout yang sudah selesai dikerjakan user
    $raport = $db->table('tryout_purchase')
        ->select('tryout_purchase.*, tryout.nama_tryout, tryout.harga, tryout.tanggal_mulai')
        ->join('tryout', 'tryout.id_tryout = tryout_purchase.id_tryout')
        ->where('tryout_purchase.id_pengguna', $id_pengguna)
        ->where('tryout_purchase.status_pengerjaan', 'Selesai')
        ->orderBy('tryout_purchase.tanggal_transaksi', 'desc')
        ->get()->getResultArray();
    
    // Hitung jumlah tryout yang sudah selesai
    $jumlahTryoutSelesai = count($raport);
    
    // Hitung ranking nasional dan provinsi untuk setiap tryout
    foreach ($raport as &$r) {
        // Ranking nasional: urutan total_score di seluruh peserta tryout ini
        $all = $db->table('tryout_purchase')
            ->where('id_tryout', $r['id_tryout'])
            ->where('status_pengerjaan', 'Selesai')
            ->orderBy('total_score', 'desc')
            ->get()->getResultArray();
        $rank_nasional = 0;
        $total_nasional = count($all);
        foreach ($all as $i => $row) {
            if ($row['id_pengguna'] == $id_pengguna) {
                $rank_nasional = $i + 1;
                break;
            }
        }
        // Ranking provinsi: urutan total_score di peserta tryout ini dengan provinsi sama
        $all_prov = $db->table('tryout_purchase')
            ->join('pengguna', 'pengguna.id_pengguna = tryout_purchase.id_pengguna')
            ->where('tryout_purchase.id_tryout', $r['id_tryout'])
            ->where('tryout_purchase.status_pengerjaan', 'Selesai')
            ->where('pengguna.provinsi', $pengguna['provinsi'])
            ->orderBy('tryout_purchase.total_score', 'desc')
            ->get()->getResultArray();
        $rank_prov = 0;
        $total_prov = count($all_prov);
        foreach ($all_prov as $i => $row) {
            if ($row['id_pengguna'] == $id_pengguna) {
                $rank_prov = $i + 1;
                break;
            }
        }
        $r['rank_nasional'] = $rank_nasional;
        $r['total_nasional'] = $total_nasional;
        $r['rank_prov'] = $rank_prov;
        $r['total_prov'] = $total_prov;
    }
    
    // Siapkan data untuk chart dari database
    $chartData = [];
    if (!empty($raport)) {
        foreach ($raport as $r) {
            $chartData[] = [
                'label' => $r['nama_tryout'],
                'score' => $r['total_score'],
                'rank_nasional_pct' => $total_nasional > 0 ? round((($total_nasional - $r['rank_nasional'] + 1) / $total_nasional) * 100, 1) : 0,
                'rank_prov_pct' => $total_prov > 0 ? round((($total_prov - $r['rank_prov'] + 1) / $total_prov) * 100, 1) : 0
            ];
        }
    }
    
    return view('Raport/Raport', [
        'pengguna' => $pengguna,
        'raport' => $raport,
        'jumlahTryoutSelesai' => $jumlahTryoutSelesai,
        'chartData' => $chartData
    ]);
}

}
