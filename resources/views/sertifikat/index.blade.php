@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('List Sertifikat') }}</h5>
                    <a href="{{ route('sertifikat.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Sertifikat
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Header -->
                    <div class="row bg-light py-2 mb-2 rounded">
                        <div class="col-2 fw-bold">Nilai</div>
                        <div class="col-2 fw-bold">Tanggal Ujian</div>
                        <div class="col-2 fw-bold">Tanggal Kadaluarsa</div>
                        <div class="col-3 fw-bold">Lembaga Penyelenggara</div>
                        <div class="col-2 fw-bold">Status</div>
                        <div class="col-1 fw-bold">Aksi</div>
                    </div>

                    <!-- Content -->
                    @forelse($sertifikats as $sertifikat)
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-2">{{ $sertifikat->nilai }}</div>
                            <div class="col-2">{{ $sertifikat->tanggal_ujian ? $sertifikat->tanggal_ujian->format('d/m/Y') : '-' }}</div>
                            <div class="col-2">{{ $sertifikat->tanggal_berakhir ? $sertifikat->tanggal_berakhir->format('d/m/Y') : '-' }}</div>
                            <div class="col-3">{{ $sertifikat->lembaga_penyelenggara }}</div>
                            <div class="col-2">
                                <span class="badge bg-{{ $sertifikat->status === 'approved' ? 'success' : ($sertifikat->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($sertifikat->status) }}
                                </span>
                                @if($sertifikat->status === 'rejected')
                                    <small class="d-block text-danger">{{ $sertifikat->alasan_penolakan }}</small>
                                @endif
                            </div>
                            <div class="col-1">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('sertifikat.preview', $sertifikat) }}" class="btn btn-info btn-sm" title="Preview Sertifikat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($sertifikat->status === 'pending')
                                        <a href="{{ route('sertifikat.edit', $sertifikat) }}" class="btn btn-warning btn-sm" title="Edit Sertifikat">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sertifikat.destroy', $sertifikat) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Sertifikat" onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="row">
                            <div class="col-12 text-center py-4">
                                {{ __('Tidak ada sertifikat yang ditemukan.') }}
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .row {
        margin-left: 0;
        margin-right: 0;
    }
    .col-1, .col-2, .col-3 {
        padding: 0.5rem;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .border-bottom {
        border-bottom: 1px solid #dee2e6;
    }
    .rounded {
        border-radius: 0.25rem;
    }
    .badge {
        font-size: 0.75rem;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .d-flex.gap-2 {
        gap: 0.5rem !important;
    }
</style>
@endsection
