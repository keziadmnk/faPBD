<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PenggunaModel;

class LoginController extends Controller
{
    public function index()
    {
        // Menampilkan halaman login
        return view('Login/Login');
    }

    public function submit()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $userModel = new PenggunaModel();
        $user = $userModel->where('email', $email)->first();
        if ($user && $user['password'] == $password) {
            session()->set('isLoggedIn', true);
            session()->set('pengguna', $user);
            return redirect()->to('/dashboard/user');
        } else {
            return redirect()->back()->with('error', 'Email atau password salah');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
