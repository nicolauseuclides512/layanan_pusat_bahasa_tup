<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // 🟢 Menampilkan dashboard berdasarkan tipe user
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('dashboard.admin'); // Blade: resources/views/dashboard/admin.blade.php
        } else {
            return view('dashboard.mahasiswa'); // Blade: resources/views/dashboard/mahasiswa.blade.php
        }
    }
}
