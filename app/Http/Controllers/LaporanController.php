<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SertifikatExport;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // 🟢 Menampilkan halaman laporan
    public function index()
    {
        return view('laporan.index', [
            'maxDate' => Carbon::today()->format('Y-m-d')
        ]);
    }

    // 🟢 Export Excel berdasarkan rentang tanggal
    public function export(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'before_or_equal:today'],
            'format' => ['required', 'in:xlsx,csv,pdf']
        ]);

        try {
            $fileName = sprintf(
                'Laporan_Sertifikat_%s_%s.%s',
                Carbon::parse($validated['start_date'])->format('Y-m-d'),
                Carbon::parse($validated['end_date'])->format('Y-m-d'),
                $validated['format']
            );

            Log::info('Report export started', [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'format' => $validated['format'],
                'user_id' => auth()->id()
            ]);

            return Excel::download(
                new SertifikatExport(
                    $validated['start_date'],
                    $validated['end_date']
                ),
                $fileName
            );

        } catch (\Exception $e) {
            Log::error('Report export failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->withErrors(['error' => 'Gagal mengekspor laporan. Silakan coba lagi.']);
        }
    }
}
