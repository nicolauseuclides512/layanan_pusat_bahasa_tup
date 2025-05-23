<?php

namespace App\Http\Controllers;

use App\Models\EprtKhusus;
use Illuminate\Http\Request;

class MahasiswaEprtKhususController extends Controller
{
    public function index()
    {
        $registrations = EprtKhusus::where('status', 'aktif')->get();
        return view('mahasiswa.eprt_khusus.index', compact('registrations'));
    }
}
