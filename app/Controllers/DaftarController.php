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
        // // Ambil input dari form
        // $email = $this->request->getPost('email');
        // $password = $this->request->getPost('password');
        // $confirmPassword = $this->request->getPost('confirm_password');
        
        // Validasi login (Contoh sederhana)
        // // Anda bisa menggunakan database atau sesi untuk autentikasi
        // if ($email == 'admin@example.com' && $password == 'password123') {
        //     // Simpan status login dalam session (gunakan session service)
        //     session()->set('isLoggedIn', true);
        //     session()->set('userEmail', $email);

        //     // Redirect ke dashboard setelah login berhasil
        //     return redirect()->to('/dashboard');
        // } else {
        //     // Jika login gagal, kembalikan ke halaman login dengan error
        //     return redirect()->back()->with('error', 'Invalid credentials');
        // }
    }
}
