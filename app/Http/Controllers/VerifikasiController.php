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
        $sertifikats = Sertifikat::with(['mahasiswa'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);
            
        return view('verifikasi.index', compact('sertifikats'));
    }

    // 🟢 Proses verifikasi sertifikat
    public function updateStatus(Request $request, Sertifikat $sertifikat)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:valid,ditolak'],
            'alasan_penolakan' => [
                'nullable',
                'required_if:status,ditolak',
                'string',
                'max:1000'
            ]
        ]);

        try {
            $oldStatus = $sertifikat->status;
            
            $sertifikat->update([
                'status' => $validated['status'],
                'alasan_penolakan' => $validated['status'] === 'ditolak' 
                    ? $validated['alasan_penolakan'] 
                    : null,
                'verified_at' => now(),
                'verified_by' => auth()->id()
            ]);

            // Send notification to student
            $sertifikat->mahasiswa->notify(new SertifikatStatusUpdated($sertifikat));

            Log::info('Certificate status updated', [
                'sertifikat_id' => $sertifikat->id,
                'old_status' => $oldStatus,
                'new_status' => $validated['status'],
                'updated_by' => auth()->id()
            ]);

            return redirect()
                ->route('verifikasi.index')
                ->with('success', 'Status sertifikat berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Certificate status update failed', [
                'sertifikat_id' => $sertifikat->id,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors(['error' => 'Gagal memperbarui status sertifikat.']);
        }
    }
}
