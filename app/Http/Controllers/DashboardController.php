<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // 🟢 Menampilkan dashboard berdasarkan tipe user
    public function mahasiswa()
    {
        return view('dashboard.mahasiswa'); // Ganti dengan path yang sesuai
    }

    public function admin()
    {
        return view('dashboard.admin'); // Ganti dengan path yang sesuai
    }
}
