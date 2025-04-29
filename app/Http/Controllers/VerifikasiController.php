<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Log;
use App\Notifications\SertifikatStatusUpdated;

class VerifikasiController extends Controller
{
    // 🟢 Menampilkan daftar sertifikat untuk diverifikasi
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $showDeleted = $request->get('show_deleted', false);

        // Query dasar dengan withTrashed() untuk melihat data yang sudah dihapus
        $query = Sertifikat::with(['mahasiswa', 'mahasiswa.programStudi']);
        
        if ($showDeleted) {
            $query->withTrashed();
        }

        // Filter berdasarkan status
        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        // Filter berdasarkan status NDE
        if ($request->has('status_nde') && $request->status_nde !== 'all') {
            $query->where('status_nde', $request->status_nde);
        }

        // Filter berdasarkan program studi
        if ($request->has('prodi') && $request->prodi !== 'all') {
            $query->whereHas('mahasiswa.programStudi', function($q) use ($request) {
                $q->where('id', $request->prodi);
            });
        }

        $sertifikats = $query->latest()->get();
        $programStudi = ProgramStudi::all();

        // Hitung jumlah sertifikat yang dihapus
        $deletedCount = Sertifikat::onlyTrashed()->count();

        return view('verifikasi.index', compact('sertifikats', 'status', 'programStudi', 'showDeleted', 'deletedCount'));
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

    // 🟢 Mengembalikan sertifikat yang sudah dihapus
    public function restore($id)
    {
        try {
            $sertifikat = Sertifikat::withTrashed()->findOrFail($id);
            $sertifikat->restore();

            return redirect()->route('verifikasi.index')
                ->with('success', 'Sertifikat berhasil dikembalikan.');
        } catch (\Exception $e) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Gagal mengembalikan sertifikat.');
        }
    }
}
