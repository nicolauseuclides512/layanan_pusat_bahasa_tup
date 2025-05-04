<?php

namespace App\Exports;

use App\Models\Sertifikat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SertifikatExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Sertifikat::query()
            ->with(['mahasiswa', 'verifier'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Mahasiswa',
            'NIM',
            'Nama Sertifikat',
            'Lembaga Penyelenggara',
            'Tanggal Ujian',
            'Tanggal Berakhir',
            'Status',
            'Diverifikasi Oleh',
            'Tanggal Verifikasi',
        ];
    }

    public function map($sertifikat): array
    {
        return [
            $sertifikat->id,
            $sertifikat->mahasiswa->nama,
            $sertifikat->mahasiswa->nim,
            $sertifikat->nama_sertifikat,
            $sertifikat->lembaga_penyelenggara,
            $sertifikat->tanggal_ujian->format('Y-m-d'),
            $sertifikat->tanggal_berakhir->format('Y-m-d'),
            $sertifikat->status,
            $sertifikat->verifier ? $sertifikat->verifier->name : '-',
            $sertifikat->verified_at ? $sertifikat->verified_at->format('Y-m-d H:i:s') : '-',
        ];
    }
}