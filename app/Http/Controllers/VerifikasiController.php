<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Log;
use App\Notifications\SertifikatStatusUpdated;

class VerifikasiController extends Controller
{
    // 🟢 Menampilkan daftar sertifikat untuk diverifikasi
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Sertifikat::with(['mahasiswa', 'mahasiswa.programStudi'])->latest();
        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }
        $sertifikats = $query->get();
        return view('verifikasi.index', compact('sertifikats', 'status'));
    }

    // 🟢 Proses verifikasi sertifikat
    public function update(Request $request, Sertifikat $sertifikat)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'alasan_penolakan' => 'required_if:status,rejected|nullable|string|max:255',
        ]);

        $sertifikat->status = (string) $request->status;
        $sertifikat->alasan_penolakan = $request->alasan_penolakan;
        $sertifikat->save();

        return redirect()->route('verifikasi.index')->with('success', 'Status sertifikat berhasil diperbarui.');
    }

    public function preview(Sertifikat $sertifikat)
    {
        return view('verifikasi.preview', compact('sertifikat'));
    }
}
