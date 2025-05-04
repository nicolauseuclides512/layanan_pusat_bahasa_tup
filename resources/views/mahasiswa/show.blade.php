@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h4 class="mb-0">Detail Mahasiswa</h4>
            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Pribadi</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $mahasiswa->nama }}</td>
                        </tr>
                        <tr>
                            <th>NIM</th>
                            <td>{{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $mahasiswa->email }}</td>
                        </tr>
                        <tr>
                            <th>Program Studi</th>
                            <td>{{ $mahasiswa->program_studi ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Pendaftaran EPrT Khusus</h5>
                </div>
                <div class="card-body">
                    @if($mahasiswa->pendaftaranEprtKhusus->isEmpty())
                        <div class="alert alert-info">Belum ada riwayat pendaftaran EPrT Khusus.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pendaftaran</th>
                                        <th>Status</th>
                                        <th>Tanggal Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mahasiswa->pendaftaranEprtKhusus as $i => $pendaftaran)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $pendaftaran->eprtKhusus->nama_pendaftaran }}</td>
                                            <td>
                                                <span class="badge bg-{{ $pendaftaran->status == 'pending' ? 'warning' : ($pendaftaran->status == 'approved' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($pendaftaran->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $pendaftaran->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Upload Sertifikat</h5>
                </div>
                <div class="card-body">
                    @if($mahasiswa->sertifikat->isEmpty())
                        <div class="alert alert-info">Belum ada sertifikat yang diupload.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dokumen</th>
                                        <th>Lembaga Penyelenggara</th>
                                        <th>Status</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mahasiswa->sertifikat as $i => $sertifikat)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $sertifikat->nama_dokumen }}</td>
                                            <td>{{ $sertifikat->lembaga_penyelenggara }}</td>
                                            <td>
                                                <span class="badge bg-{{ $sertifikat->status == 'pending' ? 'warning' : ($sertifikat->status == 'approved' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($sertifikat->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $sertifikat->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('verifikasi.preview', $sertifikat->id) }}" class="btn btn-primary btn-sm" target="_blank" title="Preview">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 