<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    // 🟢 Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register'); // Blade: resources/views/mahasiswa/register.blade.php
    }

    // 🟢 Proses registrasi mahasiswa
    public function register(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email',
            'password' => 'required|min:6|confirmed',
            'no_hp' => 'required',
            'nim' => 'required|unique:mahasiswas,nim',
            'program_studi_id' => 'required|exists:program_studis,id',
        ]);

        Mahasiswa::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'nim' => $request->nim,
            'password' => Hash::make($request->password),
            'program_studi_id' => $request->program_studi_id
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function index(Request $request)
    {
        $query = Mahasiswa::with('programStudi');

        // Filter berdasarkan program studi
        if ($request->has('prodi') && $request->prodi !== 'all') {
            $query->where('program_studi_id', $request->prodi);
        }

        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $mahasiswa = $query->latest()->get();
        $programStudi = \App\Models\ProgramStudi::all();

        return view('mahasiswa.index', compact('mahasiswa', 'programStudi'));
    }
}
