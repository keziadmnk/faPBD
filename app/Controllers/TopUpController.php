<?php
namespace App\Controllers;
use App\Models\PenggunaModel;
use CodeIgniter\Database\BaseBuilder;

class TopUpController extends BaseController
{
    public function index()
    {
        $penggunaModel = new PenggunaModel();
        $id_pengguna = session()->get('pengguna')['id_pengguna'];
        $pengguna = $penggunaModel->find($id_pengguna);
        return view('TopUp/TopUp', [
            'pengguna' => $pengguna
        ]);
    }

    public function redeem_voucher()
    {
        // Set timezone ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        
        $kode = $this->request->getPost('kode_voucher');
        if (!$kode) {
            return redirect()->back()->with('error', 'Kode voucher wajib diisi!');
        }
        $db = \Config\Database::connect();
        $voucher = $db->table('redeem_voucher')->where('kode_voucher', $kode)->get()->getRowArray();
        if (!$voucher) {
            return redirect()->back()->with('error', 'Kode voucher tidak ditemukan!');
        }
        if ($voucher['status'] !== 'aktif') {
            return redirect()->back()->with('error', 'Kode voucher sudah kadaluarsa atau sudah digunakan!');
        }
        $id_pengguna = session()->get('pengguna')['id_pengguna'];
        $penggunaModel = new PenggunaModel();
        $pengguna = $penggunaModel->find($id_pengguna);
        // Tambah saldo
        $saldo_baru = $pengguna['saldo'] + $voucher['nominal'];
        $penggunaModel->update($id_pengguna, ['saldo' => $saldo_baru]);
        // Update voucher: set id_pengguna, tanggal_digunakan, status
        $db->table('redeem_voucher')->where('kode_voucher', $kode)->update([
            'id_pengguna' => $id_pengguna,
            'tanggal_digunakan' => date('Y-m-d H:i:s'),
            'status' => 'kadaluarsa',
        ]);
        // Update session saldo
        $pengguna = $penggunaModel->find($id_pengguna);
        session()->set('pengguna', $pengguna);
        // Ambil data voucher terbaru setelah update
        $voucher = $db->table('redeem_voucher')->where('kode_voucher', $kode)->get()->getRowArray();
        return view('TopUp/DetailRedeem', [
            'pengguna' => $pengguna,
            'voucher' => $voucher
        ]);
    }

    public function history()
    {
        $penggunaModel = new PenggunaModel();
        $id_pengguna = session()->get('pengguna')['id_pengguna'];
        $pengguna = $penggunaModel->find($id_pengguna);
        // Anda bisa menambahkan query histori topup di sini jika ada
        return view('Payment/TopUpHistory', [
            'pengguna' => $pengguna
        ]);
    }
} 