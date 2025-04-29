<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function exportSertifikat(Request $request)
    {
        $query = Sertifikat::with(['mahasiswa', 'mahasiswa.programStudi']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan status_nde
        if ($request->has('status_nde') && $request->status_nde !== 'all') {
            $query->where('status_nde', $request->status_nde);
        }

        // Filter berdasarkan prodi
        if ($request->has('prodi') && $request->prodi !== 'all') {
            $query->whereHas('mahasiswa.programStudi', function($q) use ($request) {
                $q->where('id', $request->prodi);
            });
        }

        $sertifikats = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Mahasiswa');
        $sheet->setCellValue('C1', 'NIM');
        $sheet->setCellValue('D1', 'Program Studi');
        $sheet->setCellValue('E1', 'Nilai Sertifikat');
        $sheet->setCellValue('F1', 'Tanggal Ujian');
        $sheet->setCellValue('G1', 'Tanggal Kadaluarsa');
        $sheet->setCellValue('H1', 'Lembaga Penyelenggara');
        $sheet->setCellValue('I1', 'Status');
        $sheet->setCellValue('J1', 'Status NDE');
        $sheet->setCellValue('K1', 'Alasan Penolakan');

        // Isi data
        $row = 2;
        foreach ($sertifikats as $index => $sertifikat) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $sertifikat->mahasiswa->nama ?? '-');
            $sheet->setCellValue('C' . $row, $sertifikat->mahasiswa->nim ?? '-');
            $sheet->setCellValue('D' . $row, $sertifikat->mahasiswa->programStudi->nama_program_studi ?? '-');
            $sheet->setCellValue('E' . $row, $sertifikat->nilai);
            $sheet->setCellValue('F' . $row, $sertifikat->tanggal_ujian ? $sertifikat->tanggal_ujian->format('d/m/Y') : '-');
            $sheet->setCellValue('G' . $row, $sertifikat->tanggal_berakhir ? $sertifikat->tanggal_berakhir->format('d/m/Y') : '-');
            $sheet->setCellValue('H' . $row, $sertifikat->lembaga_penyelenggara);
            $sheet->setCellValue('I' . $row, ucfirst($sertifikat->status));
            $sheet->setCellValue('J' . $row, $sertifikat->status_nde ? ucfirst(str_replace('_', ' ', $sertifikat->status_nde)) : '-');
            $sheet->setCellValue('K' . $row, $sertifikat->alasan_penolakan ?? '-');
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data_Sertifikat.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
} 