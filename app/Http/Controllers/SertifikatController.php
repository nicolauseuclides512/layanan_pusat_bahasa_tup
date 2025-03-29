<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    // 🟢 Menampilkan daftar sertifikat
    public function index()
    {
        $sertifikats = Sertifikat::all();
        return view('sertifikat.index', compact('sertifikats'));
    }

    // 🟢 Menampilkan form tambah sertifikat
    public function create()
    {
        return view('sertifikat.create');
    }

    // 🟢 Menyimpan sertifikat baru
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required',
            'nama_sertifikat' => 'required',
            'lembaga_penyelenggara' => 'required',
            'tanggal_ujian' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        $filePath = $request->file('file')->store('sertifikat');

        Sertifikat::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'nama_sertifikat' => $request->nama_sertifikat,
            'lembaga_penyelenggara' => $request->lembaga_penyelenggara,
            'tanggal_ujian' => $request->tanggal_ujian,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => 'pending',
            'file_path' => $filePath
        ]);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }
}
