<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SertifikatExport;

class LaporanController extends Controller
{
    // 🟢 Menampilkan halaman laporan
    public function index()
    {
        return view('laporan.index');
    }

    // 🟢 Export Excel berdasarkan rentang tanggal
    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        return Excel::download(new SertifikatExport($request->start_date, $request->end_date), 'Laporan_Sertifikat.xlsx');
    }
}
