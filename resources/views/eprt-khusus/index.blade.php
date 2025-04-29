@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">List EPrT Khusus</h4>
                <a href="{{ route('eprt-khusus.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah EPrT Khusus
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="status" class="form-label">Filter Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pendaftaran</th>
                            <th>Tanggal Buka</th>
                            <th>Tanggal Tutup</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $index => $registration)
                            <tr>
                                <td>{{ $registrations->firstItem() + $index }}</td>
                                <td>{{ $registration->nama_pendaftaran }}</td>
                                <td>{{ $registration->tanggal_buka->format('d/m/Y H:i') }}</td>
                                <td>{{ $registration->tanggal_tutup->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $registration->status === 'aktif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('eprt-khusus.edit', $registration->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                title="Hapus"
                                                onclick="confirmDelete('{{ $registration->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $registration->id }}" 
                                              action="{{ route('eprt-khusus.destroy', $registration->id) }}" 
                                              method="POST" 
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="{{ asset('images/no-data.png') }}" 
                                         alt="No Data" 
                                         class="img-fluid mb-3" 
                                         style="max-width: 200px; opacity: 0.5">
                                    <p class="text-muted mb-0">Belum ada data EPrT Khusus</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <x-pagination-control :items="$registrations" />
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data EPrT Khusus akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

// Auto close alerts after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const closeButton = alert.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            }
        });
    }, 3000);
});
</script>
@endpush
@endsection 