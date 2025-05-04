<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranEprtKhusus;
use App\Models\EprtKhusus;

class PendaftaranEprtKhususController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'eprt_khusus_id' => 'required|exists:eprt_khusus,id',
        ]);

        $eprtKhususId = $request->eprt_khusus_id;
        $mahasiswaId = auth('mahasiswa')->id();

        // Check if already registered
        $existingRegistration = PendaftaranEprtKhusus::where('mahasiswa_id', $mahasiswaId)
            ->where('eprt_khusus_id', $eprtKhususId)
            ->first();

        if ($existingRegistration) {
            return redirect()->route('eprt_khusus.mahasiswa.index')
                ->with('error', 'Anda sudah terdaftar pada EPrT Khusus ini');
        }

        PendaftaranEprtKhusus::create([
            'mahasiswa_id' => $mahasiswaId,
            'eprt_khusus_id' => $eprtKhususId,
            'status' => 'pending'
        ]);

        return redirect()->route('eprt_khusus.mahasiswa.index')
            ->with('success', 'Pendaftaran berhasil');
    }

    public function validateRegistration(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $pendaftaran = PendaftaranEprtKhusus::findOrFail($id);
        
        // Update status
        $pendaftaran->update([
            'status' => $request->status
        ]);

        return redirect()->route('eprt_khusus.pendaftar', ['eprtKhusus' => $pendaftaran->eprt_khusus_id])
            ->with('success', 'Status pendaftaran berhasil diperbarui');
    }
}
