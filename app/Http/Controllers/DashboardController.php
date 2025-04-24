<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // 🟢 Menampilkan dashboard mahasiswa
    public function mahasiswa()
    {
        if (!Auth::guard('mahasiswa')->check()) {
            abort(403, 'Unauthorized access');
        }

        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('dashboard.mahasiswa', compact('mahasiswa'));
    }

    // 🟢 Menampilkan dashboard admin
    public function admin()
    {
        if (!Auth::check() || !(Auth::user() instanceof \App\Models\Admin)) {
            abort(403, 'Unauthorized access');
        }

        return view('dashboard.admin');
    }
}
