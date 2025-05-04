@extends('layouts.app')

@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Preview Sertifikat</h5>
                    <a href="{{ route('verifikasi.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4 print-certificate">
                        <img src="{{ asset('storage/'.$sertifikat->file_path) }}" alt="Sertifikat" class="img-fluid rounded shadow" style="max-height: 600px; width: 100%; object-fit: contain;">
                    </div>
                    <div class="row mb-4 justify-content-center">
                        <div class="col-md-8">
                            <table class="table table-borderless w-auto">
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <td>: {{ $sertifikat->mahasiswa->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Program Studi</th>
                                    <td>: {{ $sertifikat->mahasiswa->programStudi->nama_program_studi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nilai</th>
                                    <td>: {{ $sertifikat->nilai }}</td>
                                </tr>
                                <tr>
                                    <th>Lembaga</th>
                                    <td>: {{ $sertifikat->lembaga_penyelenggara }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Ujian</th>
                                    <td>: {{ $sertifikat->tanggal_ujian }}</td>
                                </tr>
                                <tr>
                                    <th>Kadaluarsa</th>
                                    <td>: {{ $sertifikat->tanggal_berakhir }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>:
                                        <span class="badge bg-{{ $sertifikat->status === 'approved' ? 'success' : ($sertifikat->status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($sertifikat->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if($sertifikat->status === 'rejected')
                                <tr>
                                    <th>Alasan Penolakan</th>
                                    <td>: <span class="text-danger">{{ $sertifikat->alasan_penolakan }}</span></td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('verifikasi.update', $sertifikat) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Validasi Sertifikat:</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="valid" value="approved" {{ $sertifikat->status == 'approved' ? 'checked' : '' }}>
                                <label class="form-check-label" for="valid">Valid</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="not_valid" value="rejected" {{ $sertifikat->status == 'rejected' ? 'checked' : '' }}>
                                <label class="form-check-label" for="not_valid">Tidak Valid</label>
                            </div>
                        </div>
                        <div class="mb-3" id="alasan_penolakan_box" @if($sertifikat->status != 'rejected') style="display:none;" @endif>
                            <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" name="alasan_penolakan" id="alasan_penolakan" rows="2">{{ $sertifikat->alasan_penolakan }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Validasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('input[name="status"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.getElementById('alasan_penolakan_box').style.display =
                this.value === 'rejected' ? '' : 'none';
        });
    });
</script>

<style>
@media print {
    body * { visibility: hidden !important; }
    .print-certificate, .print-certificate * { visibility: visible !important; }
    .print-certificate { position: absolute; left: 0; top: 0; width: 100vw; height: 100vh; display: flex; align-items: center; justify-content: center; background: #fff; z-index: 9999; }
}
</style>
@endsection