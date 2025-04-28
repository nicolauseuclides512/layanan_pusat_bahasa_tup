<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Log;
use App\Notifications\SertifikatStatusUpdated;

class VerifikasiController extends Controller
{
    // 🟢 Menampilkan daftar sertifikat untuk diverifikasi
    public function index()
    {
        $sertifikats = Sertifikat::with(['mahasiswa', 'mahasiswa.programStudi'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('verifikasi.index', compact('sertifikats'));
    }

    // 🟢 Proses verifikasi sertifikat
    public function update(Request $request, Sertifikat $sertifikat)
    {
        $request->validate([
            'status' => 'required|in:valid,invalid',
            'alasan_penolakan' => 'required_if:status,invalid|nullable|string|max:255',
        ]);

        $sertifikat->update([
            'status' => $request->status,
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()->route('verifikasi.index')->with('success', 'Status sertifikat berhasil diperbarui.');
    }

    public function preview(Sertifikat $sertifikat)
    {
        return view('verifikasi.preview', compact('sertifikat'));
    }
}
