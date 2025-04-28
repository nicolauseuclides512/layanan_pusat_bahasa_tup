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
            'nilai' => 'required|numeric|min:0|max:100',
            'tanggal_ujian' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_ujian',
            'lembaga_penyelenggara' => 'required|string|max:255',
        ]);

        $path = $request->file('gambar_sertifikat')->store('sertifikats', 'public');

        Sertifikat::create([
            'user_id' => auth()->id(),
            'gambar_sertifikat' => $path,
            'nilai' => $request->nilai,
            'tanggal_ujian' => $request->tanggal_ujian,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'lembaga_penyelenggara' => $request->lembaga_penyelenggara,
            'status' => 'pending',
        ]);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function update(Request $request, Sertifikat $sertifikat)
    {
        if ($sertifikat->status !== 'pending') {
            return back()->withErrors(['status' => 'Sertifikat yang sudah divalidasi tidak dapat diubah.']);
        }

        $request->validate([
            'gambar_sertifikat' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nilai' => 'required|numeric|min:0|max:100',
            'tanggal_ujian' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_ujian',
            'lembaga_penyelenggara' => 'required|string|max:255',
        ]);

        if ($request->hasFile('gambar_sertifikat')) {
            Storage::disk('public')->delete($sertifikat->gambar_sertifikat);
            $path = $request->file('gambar_sertifikat')->store('sertifikats', 'public');
            $sertifikat->gambar_sertifikat = $path;
        }

        $sertifikat->update([
            'nilai' => $request->nilai,
            'tanggal_ujian' => $request->tanggal_ujian,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'lembaga_penyelenggara' => $request->lembaga_penyelenggara,
        ]);

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Sertifikat $sertifikat)
    {
        if ($sertifikat->status !== 'pending') {
            return back()->withErrors(['status' => 'Sertifikat yang sudah divalidasi tidak dapat dihapus.']);
        }

        Storage::disk('public')->delete($sertifikat->gambar_sertifikat);
        $sertifikat->delete();

        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function preview(Sertifikat $sertifikat)
    {
        return view('sertifikat.preview', compact('sertifikat'));
    }
}
