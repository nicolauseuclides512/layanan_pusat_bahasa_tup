<?php

namespace App\Http\Controllers;

use App\Models\EprtKhusus;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EprtKhususController extends Controller
{
    public function index(Request $request)
    {
        // Update status semua registrasi
        EprtKhusus::updateAllStatus();

        $query = EprtKhusus::latest();

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Handle pagination
        $perPage = $request->get('per_page', 20);
        $registrations = $perPage == 'all' 
            ? $query->get() 
            : $query->paginate($perPage)->withQueryString();

        if ($perPage == 'all') {
            $page = $request->get('page', 1);
            $total = $registrations->count();
            $registrations = new \Illuminate\Pagination\LengthAwarePaginator(
                $registrations->forPage($page, $total),
                $total,
                $total,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }
        
        return view('eprt-khusus.index', compact('registrations'));
    }

    public function create()
    {
        return view('eprt_khusus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pendaftaran' => 'required|string|max:255',
            'tanggal_buka' => 'required|date',
            'jam_buka' => 'required|string|size:2',
            'menit_buka' => 'required|string|size:2',
            'tanggal_tutup' => 'required|date|after:tanggal_buka',
            'jam_tutup' => 'required|string|size:2',
            'menit_tutup' => 'required|string|size:2'
        ]);

        $tanggalBuka = Carbon::parse($request->tanggal_buka . ' ' . $request->jam_buka . ':' . $request->menit_buka);
        $tanggalTutup = Carbon::parse($request->tanggal_tutup . ' ' . $request->jam_tutup . ':' . $request->menit_tutup);

        // Validasi tambahan untuk memastikan tanggal tutup setelah tanggal buka
        if ($tanggalTutup->lte($tanggalBuka)) {
            return back()->withErrors(['tanggal_tutup' => 'Tanggal tutup harus setelah tanggal buka'])->withInput();
        }

        // Set status awal berdasarkan tanggal
        $status = Carbon::now()->gt($tanggalTutup) ? 'nonaktif' : 'aktif';

        EprtKhusus::create([
            'nama_pendaftaran' => $request->nama_pendaftaran,
            'tanggal_buka' => $tanggalBuka,
            'tanggal_tutup' => $tanggalTutup,
            'status' => $status
        ]);

        return redirect()->route('eprt-khusus.index')
            ->with('success', 'Pendaftaran EPrT Khusus berhasil ditambahkan.');
    }

    public function edit(EprtKhusus $eprtKhusus)
    {
        return view('eprt_khusus.edit', compact('eprtKhusus'));
    }

    public function update(Request $request, EprtKhusus $eprtKhusus)
    {
        $request->validate([
            'nama_pendaftaran' => 'required|string|max:255',
            'tanggal_buka' => 'required|date',
            'jam_buka' => [
                'required',
                'string',
                'size:2',
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value) || $value < 0 || $value > 23) {
                        $fail('Format jam tidak valid. Gunakan format 00-23.');
                    }
                },
            ],
            'menit_buka' => [
                'required',
                'string',
                'size:2',
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value) || $value < 0 || $value > 59) {
                        $fail('Format menit tidak valid. Gunakan format 00-59.');
                    }
                },
            ],
            'tanggal_tutup' => 'required|date',
            'jam_tutup' => [
                'required',
                'string',
                'size:2',
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value) || $value < 0 || $value > 23) {
                        $fail('Format jam tidak valid. Gunakan format 00-23.');
                    }
                },
            ],
            'menit_tutup' => [
                'required',
                'string',
                'size:2',
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value) || $value < 0 || $value > 59) {
                        $fail('Format menit tidak valid. Gunakan format 00-59.');
                    }
                },
            ],
        ]);

        try {
            $tanggalBuka = Carbon::parse($request->tanggal_buka . ' ' . $request->jam_buka . ':' . $request->menit_buka);
            $tanggalTutup = Carbon::parse($request->tanggal_tutup . ' ' . $request->jam_tutup . ':' . $request->menit_tutup);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Format tanggal atau waktu tidak valid.'])->withInput();
        }

        // Validasi tambahan untuk memastikan tanggal tutup setelah tanggal buka
        if ($tanggalTutup->lte($tanggalBuka)) {
            return back()->withErrors(['tanggal_tutup' => 'Tanggal dan waktu tutup harus setelah tanggal dan waktu buka'])->withInput();
        }

        // Update status berdasarkan tanggal
        $now = Carbon::now('Asia/Jakarta');
        $status = $now->gt($tanggalTutup) ? 'nonaktif' : 'aktif';

        try {
            $eprtKhusus->update([
                'nama_pendaftaran' => $request->nama_pendaftaran,
                'tanggal_buka' => $tanggalBuka,
                'tanggal_tutup' => $tanggalTutup,
                'status' => $status
            ]);

            return redirect()->route('eprt-khusus.index')
                ->with('success', 'Pendaftaran EPrT Khusus berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }

    public function destroy(EprtKhusus $eprtKhusus)
    {
        try {
            DB::beginTransaction();
            
            // Hapus data EPrT Khusus
            $eprtKhusus->delete();
            
            DB::commit();
            
            return redirect()->route('eprt-khusus.index')
                ->with('success', 'Pendaftaran EPrT Khusus berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('eprt-khusus.index')
                ->with('error', 'Terjadi kesalahan saat menghapus pendaftaran EPrT Khusus.');
        }
    }

    public function mahasiswaIndex()
    {
        $registrations = EprtKhusus::where('status', 'aktif')->orderBy('tanggal_buka', 'asc')->get();
        return view('mahasiswa.eprt_khusus.index', compact('registrations'));
    }
} 