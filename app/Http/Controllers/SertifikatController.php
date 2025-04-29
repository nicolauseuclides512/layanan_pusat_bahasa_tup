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
        if (auth('web')->check()) {
            $sertifikats = \App\Models\Sertifikat::with(['mahasiswa', 'mahasiswa.programStudi'])->latest()->get();
            return view('sertifikat.index_admin', compact('sertifikats'));
        } elseif (auth('mahasiswa')->check()) {
            $mahasiswaId = auth('mahasiswa')->user()->id;
            $sertifikats = \App\Models\Sertifikat::where('mahasiswa_id', $mahasiswaId)->latest()->get();
            return view('sertifikat.index', compact('sertifikats'));
        } else {
            abort(403);
        }
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
            'gambar_sertifikat' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nilai' => 'required|numeric|min:0|max:700',
            'tanggal_ujian' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_ujian',
            'lembaga_penyelenggara' => 'required|string|max:255',
        ]);

        $path = $request->file('gambar_sertifikat')->store('sertifikats', 'public');
        $mahasiswaId = auth('mahasiswa')->user()->id;

        Sertifikat::create([
            'mahasiswa_id' => $mahasiswaId,
            'nama_dokumen' => $request->file('gambar_sertifikat')->getClientOriginalName(),
            'file_path' => $path,
            'nilai' => $request->nilai,
            'tanggal_ujian' => $request->tanggal_ujian,
            'tanggal_berakhir' => $request->tanggal_kadaluarsa,
            'lembaga_penyelenggara' => $request->lembaga_penyelenggara,
            'status' => 'pending',
        ]);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function update(Request $request, Sertifikat $sertifikat)
    {
        if ($sertifikat->status === 'approved') {
            return back()->withErrors(['status' => 'Sertifikat yang sudah disetujui tidak dapat diubah.']);
        }

        $request->validate([
            'gambar_sertifikat' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nilai' => 'required|numeric|min:0|max:700',
            'tanggal_ujian' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_ujian',
            'lembaga_penyelenggara' => 'required|string|max:255',
        ]);

        if ($request->hasFile('gambar_sertifikat')) {
            Storage::disk('public')->delete($sertifikat->file_path);
            $path = $request->file('gambar_sertifikat')->store('sertifikats', 'public');
            $sertifikat->file_path = $path;
            $sertifikat->nama_dokumen = $request->file('gambar_sertifikat')->getClientOriginalName();
        }

        $sertifikat->update([
            'nilai' => $request->nilai,
            'tanggal_ujian' => $request->tanggal_ujian,
            'tanggal_berakhir' => $request->tanggal_kadaluarsa,
            'lembaga_penyelenggara' => $request->lembaga_penyelenggara,
            'status' => 'pending',
            'alasan_penolakan' => null
        ]);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Sertifikat $sertifikat)
    {
        // Cek apakah user adalah pemilik sertifikat
        if (auth('mahasiswa')->check() && $sertifikat->mahasiswa_id !== auth('mahasiswa')->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus sertifikat ini.');
        }

        // Cek apakah sertifikat masih bisa dihapus
        if ($sertifikat->status !== 'pending') {
            return redirect()->route('sertifikat.index')->with('error', 'Sertifikat yang sudah divalidasi tidak dapat dihapus.');
        }

        try {
            // Hapus file dari storage jika ada file_path
            if (!empty($sertifikat->file_path)) {
                \Storage::disk('public')->delete($sertifikat->file_path);
            }
            $sertifikat->delete();
            return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('sertifikat.index')->with('error', 'Terjadi kesalahan saat menghapus sertifikat.');
        }
    }

    public function preview(Sertifikat $sertifikat)
    {
        return view('sertifikat.preview', compact('sertifikat'));
    }

    public function edit(Sertifikat $sertifikat)
    {
        // Check if the user is the owner of the certificate
        if ($sertifikat->mahasiswa_id !== auth('mahasiswa')->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if the certificate can be edited
        if ($sertifikat->status === 'approved') {
            return back()->withErrors(['status' => 'Sertifikat yang sudah disetujui tidak dapat diubah.']);
        }

        return view('sertifikat.edit', compact('sertifikat'));
    }

    public function updateNde(Request $request, Sertifikat $sertifikat)
    {
        $request->validate([
            'status_nde' => 'required|in:belum_terkirim,terkirim'
        ]);

        $sertifikat->update([
            'status_nde' => $request->status_nde
        ]);

        return redirect()->route('verifikasi.index')->with('success', 'Status NDE berhasil diperbarui.');
    }
}
