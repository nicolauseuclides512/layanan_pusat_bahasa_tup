<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SertifikatController extends Controller
{
    // 🟢 Menampilkan daftar sertifikat
    public function index()
    {
        $sertifikats = Sertifikat::with(['mahasiswa'])
            ->latest()
            ->paginate(15);
            
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
        $validated = $request->validate([
            'mahasiswa_id' => ['required', 'exists:mahasiswas,id'],
            'nama_sertifikat' => ['required', 'string', 'max:255'],
            'lembaga_penyelenggara' => ['required', 'string', 'max:255'],
            'tanggal_ujian' => ['required', 'date', 'before_or_equal:today'],
            'tanggal_berakhir' => ['required', 'date', 'after:tanggal_ujian'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:5120'] // 5MB max
        ]);

        try {
            $fileName = Str::uuid() . '.' . $request->file('file')->getClientOriginalExtension();
            $filePath = $request->file('file')->storeAs(
                'sertifikat/' . date('Y/m'),
                $fileName,
                'public'
            );

            $sertifikat = Sertifikat::create([
                'mahasiswa_id' => $validated['mahasiswa_id'],
                'nama_sertifikat' => $validated['nama_sertifikat'],
                'lembaga_penyelenggara' => $validated['lembaga_penyelenggara'],
                'tanggal_ujian' => $validated['tanggal_ujian'],
                'tanggal_berakhir' => $validated['tanggal_berakhir'],
                'status' => 'pending',
                'file_path' => $filePath
            ]);

            Log::info('Certificate uploaded successfully', [
                'sertifikat_id' => $sertifikat->id,
                'mahasiswa_id' => $validated['mahasiswa_id']
            ]);

            return redirect()
                ->route('sertifikat.index')
                ->with('success', 'Sertifikat berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Certificate upload failed', [
                'error' => $e->getMessage(),
                'mahasiswa_id' => $validated['mahasiswa_id']
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal mengunggah sertifikat. Silakan coba lagi.']);
        }
    }

    public function destroy(Sertifikat $sertifikat)
    {
        try {
            if ($sertifikat->file_path && Storage::exists($sertifikat->file_path)) {
                Storage::delete($sertifikat->file_path);
            }
            
            $sertifikat->delete();
            
            return redirect()
                ->route('sertifikat.index')
                ->with('success', 'Sertifikat berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Certificate deletion failed', [
                'sertifikat_id' => $sertifikat->id,
                'error' => $e->getMessage()
            ]);
            
            return back()->withErrors(['error' => 'Gagal menghapus sertifikat.']);
        }
    }
}
