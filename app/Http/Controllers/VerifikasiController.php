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
        try {
            $request->validate([
                'status' => 'required|in:approved,rejected',
                'alasan_penolakan' => 'required_if:status,rejected|nullable|string|max:255|not_in:-',
            ], [
                'alasan_penolakan.required_if' => 'Alasan penolakan harus diisi jika status ditolak',
                'alasan_penolakan.not_in' => 'Alasan penolakan tidak boleh hanya berisi tanda strip (-)',
            ]);

            $sertifikat->status = (string) $request->status;
            $sertifikat->alasan_penolakan = $request->status === 'approved' ? '-' : $request->alasan_penolakan;
            
            // Set status_nde to belum_terkirim when status is approved
            if ($request->status === 'approved') {
                $sertifikat->status_nde = 'belum_terkirim';
            }
            
            $sertifikat->save();

            return redirect()->route('verifikasi.index')->with('success', 'Status sertifikat berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->validator)
                ->with('showModal', $sertifikat->id)
                ->with('error', 'Validasi gagal. Silakan periksa kembali input Anda.');
        }
    }

    public function preview(Sertifikat $sertifikat)
    {
        return view('verifikasi.preview', compact('sertifikat'));
    }
}
