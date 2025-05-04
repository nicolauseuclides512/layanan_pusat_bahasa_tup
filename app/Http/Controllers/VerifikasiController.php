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

        // Handle pagination
        $perPage = $request->get('per_page', 20);
        $sertifikats = $perPage == 'all' 
            ? $query->latest()->get() 
            : $query->latest()->paginate($perPage)->withQueryString();

        if ($perPage == 'all') {
            $page = $request->get('page', 1);
            $total = $sertifikats->count();
            $sertifikats = new \Illuminate\Pagination\LengthAwarePaginator(
                $sertifikats->forPage($page, $total),
                $total,
                $total,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        $programStudi = ProgramStudi::all();
        $deletedCount = Sertifikat::onlyTrashed()->count();

        return view('verifikasi.index', compact('sertifikats', 'status', 'programStudi', 'showDeleted', 'deletedCount'));
    }

    // 🟢 Proses verifikasi sertifikat
    public function update(Request $request, Sertifikat $sertifikat)
    {
            $request->validate([
                'status' => 'required|in:approved,rejected',
            'alasan_penolakan' => 'required_if:status,rejected'
            ]);

        $sertifikat->status = $request->status;
        $sertifikat->alasan_penolakan = $request->status === 'rejected' ? $request->alasan_penolakan : null;
            $sertifikat->save();

        return redirect()->route('verifikasi.index')->with('success', 'Validasi sertifikat berhasil disimpan.');
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
