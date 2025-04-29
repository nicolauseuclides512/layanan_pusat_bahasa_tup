<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    // 🟢 Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register'); // Blade: resources/views/mahasiswa/register.blade.php
    }

    // 🟢 Proses registrasi mahasiswa
    public function register(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswas,email',
            'password' => 'required|min:6|confirmed',
            'no_hp' => 'required',
            'nim' => 'required|unique:mahasiswas,nim',
            'program_studi_id' => 'required|exists:program_studis,id',
        ]);

        Mahasiswa::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'nim' => $request->nim,
            'password' => Hash::make($request->password),
            'program_studi_id' => $request->program_studi_id
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function index(Request $request)
    {
        $query = Mahasiswa::with('programStudi');
        $programStudis = ProgramStudi::all();

        // Filter berdasarkan program studi
        if ($request->filled('prodi')) {
            $query->where('program_studi_id', $request->prodi);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Handle pagination
        $perPage = $request->get('per_page', 20);
        $mahasiswas = $perPage == 'all' 
            ? $query->get() 
            : $query->paginate($perPage)->withQueryString();

        if ($perPage == 'all') {
            // Convert collection to LengthAwarePaginator for consistent view handling
            $page = $request->get('page', 1);
            $total = $mahasiswas->count();
            $mahasiswas = new \Illuminate\Pagination\LengthAwarePaginator(
                $mahasiswas->forPage($page, $total),
                $total,
                $total,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        return view('mahasiswa.index', compact('mahasiswas', 'programStudis'));
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load(['programStudi', 'sertifikat' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function create()
    {
        $programStudis = ProgramStudi::all();
        return view('mahasiswa.create', compact('programStudis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas,nim|max:20',
            'program_studi_id' => 'required|exists:program_studis,id',
            'email' => 'required|email|unique:mahasiswas,email|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        Mahasiswa::create($validated);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $programStudis = ProgramStudi::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'programStudis'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
            'program_studi_id' => 'required|exists:program_studis,id',
            'email' => 'required|email|max:255|unique:mahasiswas,email,' . $mahasiswa->id,
            'no_hp' => 'required|string|max:15',
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        try {
            $mahasiswa->delete();
            return redirect()->route('mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.index')
                ->with('error', 'Gagal menghapus data mahasiswa. Pastikan tidak ada data terkait.');
        }
    }
}
