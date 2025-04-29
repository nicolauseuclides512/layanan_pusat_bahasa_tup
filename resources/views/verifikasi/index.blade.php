@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('List Sertifikat') }}</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('verifikasi.index') }}" method="GET" class="mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Filter Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status_nde" class="form-label">Filter Status NDE</label>
                                <select name="status_nde" id="status_nde" class="form-select">
                                    <option value="all" {{ request('status_nde') === 'all' ? 'selected' : '' }}>Semua Status NDE</option>
                                    <option value="belum_terkirim" {{ request('status_nde') === 'belum_terkirim' ? 'selected' : '' }}>Belum Terkirim</option>
                                    <option value="terkirim" {{ request('status_nde') === 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="prodi" class="form-label">Filter Program Studi</label>
                                <select name="prodi" id="prodi" class="form-select">
                                    <option value="all" {{ request('prodi') === 'all' ? 'selected' : '' }}>Semua Program Studi</option>
                                    @foreach($programStudi as $ps)
                                        <option value="{{ $ps->id }}" {{ request('prodi') == $ps->id ? 'selected' : '' }}>
                                            {{ $ps->nama_program_studi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('export.sertifikat', request()->query()) }}" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Header -->
                    <div class="row bg-light py-2 mb-2 rounded">
                        <div class="col-2 fw-bold">Nama Mahasiswa</div>
                        <div class="col-1 fw-bold">NIM</div>
                        <div class="col-2 fw-bold">Prodi</div>
                        <div class="col-1 fw-bold">Nilai</div>
                        <div class="col-1 fw-bold">Tanggal Ujian</div>
                        <div class="col-1 fw-bold">Kadaluarsa</div>
                        <div class="col-2 fw-bold">Lembaga</div>
                        <div class="col-1 fw-bold">Status</div>
                        <div class="col-1 fw-bold">Status NDE</div>
                    </div>

                    <!-- Content -->
                    @forelse($sertifikats as $sertifikat)
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-2">{{ $sertifikat->mahasiswa ? $sertifikat->mahasiswa->nama : '-' }}</div>
                            <div class="col-1">{{ $sertifikat->mahasiswa ? $sertifikat->mahasiswa->nim : '-' }}</div>
                            <div class="col-2">{{ $sertifikat->mahasiswa && $sertifikat->mahasiswa->programStudi ? $sertifikat->mahasiswa->programStudi->nama_program_studi : '-' }}</div>
                            <div class="col-1">{{ $sertifikat->nilai }}</div>
                            <div class="col-1">{{ $sertifikat->tanggal_ujian ? $sertifikat->tanggal_ujian->format('d/m/Y') : '-' }}</div>
                            <div class="col-1">{{ $sertifikat->tanggal_berakhir ? $sertifikat->tanggal_berakhir->format('d/m/Y') : '-' }}</div>
                            <div class="col-2">{{ $sertifikat->lembaga_penyelenggara }}</div>
                            <div class="col-1">
                                <span class="badge bg-{{ $sertifikat->status === 'approved' ? 'success' : ($sertifikat->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($sertifikat->status) }}
                                </span>
                            </div>
                            <div class="col-1">
                                @if($sertifikat->status === 'approved')
                                    <span class="badge bg-{{ $sertifikat->status_nde === 'terkirim' ? 'success' : 'warning' }}">
                                        {{ $sertifikat->status_nde === 'terkirim' ? 'Terkirim' : 'Belum Terkirim' }}
                                    </span>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateNdeModal{{ $sertifikat->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        @if($sertifikat->status === 'pending')
                            @include('verifikasi.partials.verifikasi_modal', ['sertifikat' => $sertifikat])
                        @endif

                        @if($sertifikat->status === 'approved')
                            @include('verifikasi.partials.update_nde_modal', ['sertifikat' => $sertifikat])
                        @endif
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
    .col-1, .col-2 {
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
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/verifikasi.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal ID from PHP session
    const modalId = "{{ session('showModal') }}";
    
    // If there's a modal ID, show the modal
    if (modalId) {
        const modalElement = document.getElementById('verifikasiModal' + modalId);
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    }
});
</script>
@endsection
