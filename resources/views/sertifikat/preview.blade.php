@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Preview Sertifikat</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4 print-certificate">
                        <img src="{{ Storage::url($sertifikat->file_path) }}" alt="Sertifikat" class="img-fluid rounded" style="max-height: 500px;">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">Nama Dokumen</th>
                                    <td>{{ $sertifikat->nama_dokumen }}</td>
                                </tr>
                                <tr>
                                    <th>Nilai Sertifikat</th>
                                    <td>{{ $sertifikat->nilai }}</td>
                                </tr>
                                <tr>
                                    <th>Lembaga Penyelenggara</th>
                                    <td>{{ $sertifikat->lembaga_penyelenggara }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Ujian</th>
                                    <td>{{ $sertifikat->tanggal_ujian->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kadaluarsa</th>
                                    <td>{{ $sertifikat->tanggal_berakhir->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($sertifikat->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($sertifikat->status === 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($sertifikat->status === 'rejected')
                                <tr>
                                    <th>Alasan Penolakan</th>
                                    <td>{{ $sertifikat->alasan_penolakan }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('sertifikat.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        @if($sertifikat->status === 'pending')
                        <form action="{{ route('sertifikat.destroy', $sertifikat) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden !important; }
    .print-certificate, .print-certificate * { visibility: visible !important; }
    .print-certificate { position: absolute; left: 0; top: 0; width: 100vw; height: 100vh; display: flex; align-items: center; justify-content: center; background: #fff; z-index: 9999; }
}
</style>
@endsection 