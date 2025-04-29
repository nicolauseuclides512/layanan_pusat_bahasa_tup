@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detail Mahasiswa</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Informasi Mahasiswa -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Mahasiswa</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 35%"><strong>Nama</strong></td>
                            <td>: {{ $mahasiswa->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIM</strong></td>
                            <td>: {{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <td><strong>Program Studi</strong></td>
                            <td>: {{ $mahasiswa->programStudi->nama_program_studi }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: {{ $mahasiswa->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. HP</strong></td>
                            <td>: {{ $mahasiswa->no_hp }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terdaftar</strong></td>
                            <td>: {{ $mahasiswa->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Riwayat Sertifikat -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Riwayat Sertifikat</h5>
                    
                    @if($mahasiswa->sertifikat->count() > 0)
                        <div class="list-group">
                            @foreach($mahasiswa->sertifikat as $sertifikat)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $sertifikat->jenis_sertifikat }}</h6>
                                            <p class="mb-1 text-muted">
                                                <small>
                                                    <i class="fas fa-calendar-alt"></i> 
                                                    {{ $sertifikat->created_at->format('d M Y') }}
                                                </small>
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="badge rounded-pill bg-{{ $sertifikat->status == 'approved' ? 'success' : ($sertifikat->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($sertifikat->status) }}
                                            </span>
                                            @if($sertifikat->status_nde)
                                                <span class="badge rounded-pill bg-info">
                                                    {{ $sertifikat->status_nde }}
                                                </span>
                                            @endif
                                            <a href="{{ route('verifikasi.show', $sertifikat->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <img src="{{ asset('images/no-data.png') }}" 
                                 alt="No Certificates" 
                                 style="max-width: 200px; opacity: 0.5;">
                            <p class="mt-3 text-muted">Belum ada sertifikat yang diajukan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 