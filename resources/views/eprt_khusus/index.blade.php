@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('List EPrT Khusus') }}</h5>
                    <a href="{{ route('eprt_khusus.create') }}" class="btn btn-primary">
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pendaftaran</th>
                                    <th>Tanggal Buka</th>
                                    <th>Tanggal Tutup</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eprtKhusus as $i => $eprt)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>
                                            <a href="{{ route('eprt_khusus.pendaftar', ['eprtKhusus' => $eprt->id]) }}" class="text-decoration-underline text-primary" title="Lihat Pendaftar">
                                                {{ $eprt->nama_pendaftaran }}
                                            </a>
                                        </td>
                                        <td>{{ $eprt->tanggal_buka->format('d/m/Y H:i') }}</td>
                                        <td>{{ $eprt->tanggal_tutup->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $eprt->status === 'aktif' ? 'success' : 'danger' }}">
                                                {{ ucfirst($eprt->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('eprt_khusus.edit', $eprt) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('eprt_khusus.pendaftar', ['eprtKhusus' => $eprt->id]) }}" class="btn btn-info btn-sm" title="Lihat Pendaftar">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <form action="{{ route('eprt_khusus.destroy', $eprt) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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