<?php

namespace App\Exports;

use App\Models\Sertifikat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Storage;

class SertifikatExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // 🟢 Data yang diekspor
    public function collection()
    {
        return Sertifikat::where('status', 'valid')
            ->whereBetween('tanggal_ujian', [$this->startDate, $this->endDate])
            ->get(['nama_sertifikat', 'lembaga_penyelenggara', 'tanggal_ujian', 'tanggal_berakhir', 'file_path'])
            ->map(function ($sertifikat) {
                return [
                    'Nama Sertifikat' => $sertifikat->nama_sertifikat,
                    'Lembaga' => $sertifikat->lembaga_penyelenggara,
                    'Tanggal Ujian' => $sertifikat->tanggal_ujian,
                    'Tanggal Berakhir' => $sertifikat->tanggal_berakhir,
                    'Link Sertifikat' => url(Storage::url($sertifikat->file_path))
                ];
            });
    }

    // 🟢 Header kolom dalam file Excel
    public function headings(): array
    {
        return ['Nama Sertifikat', 'Lembaga', 'Tanggal Ujian', 'Tanggal Berakhir', 'Link Sertifikat'];
    }
}
