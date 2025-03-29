<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;

class VerifikasiController extends Controller
{
    // 🟢 Menampilkan daftar sertifikat untuk diverifikasi
    public function index()
    {
        $sertifikats = Sertifikat::where('status', 'pending')->get();
        return view('verifikasi.index', compact('sertifikats'));
    }

    // 🟢 Proses verifikasi sertifikat
    public function updateStatus(Request $request, Sertifikat $sertifikat)
    {
        $request->validate([
            'status' => 'required|in:valid,ditolak',
            'alasan_penolakan' => 'nullable|required_if:status,ditolak'
        ]);

        $sertifikat->update([
            'status' => $request->status,
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return redirect()->route('verifikasi.index')->with('success', 'Status sertifikat berhasil diperbarui.');
    }
}
