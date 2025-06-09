<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class LandingPageController extends BaseController
{
    public function index()
    {
        // Menampilkan file LandingPage.php yang ada di folder LandingPage
        return view('LandingPage/LandingPage');
    }
}
