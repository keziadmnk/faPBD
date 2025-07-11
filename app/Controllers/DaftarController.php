<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DaftarController extends Controller
{
    public function index()
    {
        // Menampilkan halaman login
        return view('Daftar/Daftar');
    }

    public function submit()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validasi sederhana
        if ($password !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error', 'Konfirmasi password tidak cocok!');
        }
        if (empty($email) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Email dan password wajib diisi!');
        }

        $penggunaModel = new \App\Models\PenggunaModel();
        // Cek email sudah terdaftar
        if ($penggunaModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar!');
        }

        $data = [
            'email' => $email,
            'password' => $password, // Tidak di-hash sesuai database
            'nama' => 'Pengguna Baru',
            'tanggal_lahir' => '', // Jangan isi otomatis, biarkan kosong
            'provinsi' => '',
            'kabupaten' => '',
            'tanggal_daftar' => date('Y-m-d H:i:s'),
            'saldo' => 0,
            'nomor_hp' => ''
        ];
        $penggunaModel->insert($data);
        $id_pengguna = $penggunaModel->getInsertID();
        // Login otomatis
        $pengguna = $penggunaModel->find($id_pengguna);
        session()->set('pengguna', $pengguna);
        
        // Debug: cek apakah session tersimpan
        if (session()->get('pengguna')) {
            // Redirect ke lengkapi profil
            return redirect()->to('/complete-registration');
        } else {
            // Fallback ke login jika ada masalah
            return redirect()->to('/login')->with('error', 'Gagal login otomatis. Silakan login manual.');
        }
    }

    public function completeRegistration()
    {
        $pengguna = session()->get('pengguna');
        return view('Daftar/CompleteRegistration', ['pengguna' => $pengguna]);
    }

    public function saveCompleteRegistration()
    {
        $id_pengguna = session()->get('pengguna')['id_pengguna'];
        $penggunaModel = new \App\Models\PenggunaModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'nomor_hp' => $this->request->getPost('nomor_hp'),
            'provinsi' => $this->request->getPost('provinsi'),
            'kabupaten' => $this->request->getPost('kabupaten'),
        ];
        $penggunaModel->update($id_pengguna, $data);
        // Update session
        $pengguna = $penggunaModel->find($id_pengguna);
        session()->set('pengguna', $pengguna);
        return redirect()->to('/dashboard/user')->with('success', 'Profil berhasil dilengkapi!');
    }
}
