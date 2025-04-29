@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('List EPrT Khusus') }}</h5>
                    <a href="{{ route('eprt-khusus.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah EPrT Khusus
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Header -->
                    <div class="row bg-light py-2 mb-2 rounded">
                        <div class="col-3 fw-bold">Nama Pendaftaran</div>
                        <div class="col-3 fw-bold">Tanggal Buka</div>
                        <div class="col-3 fw-bold">Tanggal Tutup</div>
                        <div class="col-2 fw-bold">Status</div>
                        <div class="col-1 fw-bold">Aksi</div>
                    </div>

                    <!-- Content -->
                    @forelse($eprtKhusus as $eprt)
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-3">{{ $eprt->nama_pendaftaran }}</div>
                            <div class="col-3">{{ $eprt->tanggal_buka->format('d/m/Y H:i') }}</div>
                            <div class="col-3">{{ $eprt->tanggal_tutup->format('d/m/Y H:i') }}</div>
                            <div class="col-2">
                                <span class="badge bg-{{ $eprt->status === 'aktif' ? 'success' : 'danger' }}">
                                    {{ ucfirst($eprt->status) }}
                                </span>
                            </div>
                            <div class="col-1">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('eprt-khusus.edit', $eprt) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('eprt-khusus.destroy', $eprt) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="row">
                            <div class="col-12 text-center py-4">
                                {{ __('Tidak ada pendaftaran EPrT Khusus yang ditemukan.') }}
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
    .alert {
        margin-bottom: 1rem;
    }
    .alert-dismissible .btn-close {
        padding: 0.5rem 0.5rem;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Konfirmasi hapus dengan SweetAlert
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pendaftaran EPrT Khusus akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
@endsection 