@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Mahasiswa</h4>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Mahasiswa
                </a>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="row mb-3">
        <div class="col-md-8">
            <form method="GET" action="" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label for="prodi" class="form-label mb-1">Program Studi</label>
                    <select name="prodi" id="prodi" class="form-select">
                        <option value="">-- Semua Program Studi --</option>
                        @foreach($programStudis as $prodi)
                            <option value="{{ $prodi->id }}" {{ request('prodi') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_program_studi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="search" class="form-label mb-1">Cari Nama/NIM</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari nama atau NIM..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info w-100"><i class="fas fa-search"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">No</th>
                            <th scope="col" style="width: 20%">Nama</th>
                            <th scope="col" style="width: 15%">NIM</th>
                            <th scope="col" style="width: 20%">Program Studi</th>
                            <th scope="col" style="width: 15%">Email</th>
                            <th scope="col" style="width: 15%">No. HP</th>
                            <th scope="col" class="text-center" style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswas as $index => $mhs)
                            <tr>
                                <td class="text-center">{{ $mahasiswas->firstItem() + $index }}</td>
                                <td>{{ $mhs->nama }}</td>
                                <td>{{ $mhs->nim }}</td>
                                <td>{{ $mhs->programStudi->nama_program_studi ?? '-' }}</td>
                                <td>{{ $mhs->email }}</td>
                                <td>{{ $mhs->no_hp }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('mahasiswa.show', $mhs->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('mahasiswa.edit', $mhs->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                title="Hapus"
                                                onclick="confirmDelete('{{ $mhs->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $mhs->id }}" 
                                              action="{{ route('mahasiswa.destroy', $mhs->id) }}" 
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
                                <td colspan="7" class="text-center py-5">
                                    <img src="{{ asset('images/no-data.png') }}" 
                                         alt="No Data" 
                                         class="img-fluid mb-3" 
                                         style="max-width: 200px; opacity: 0.5">
                                    <p class="text-muted mb-0">Belum ada data mahasiswa</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <x-pagination-control :items="$mahasiswas" />
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data mahasiswa akan dihapus permanen!",
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
        const alert = document.getElementById('success-alert');
        if(alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 500);
        }
    }, 2500);
});
</script>

<style>
.pagination {
    margin-bottom: 0;
}
.page-item:first-child .page-link {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}
.page-item:last-child .page-link {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}
.page-link {
    padding: 0.5rem 0.75rem;
    color: #0d6efd;
    background-color: #fff;
    border: 1px solid #dee2e6;
}
.page-link:hover {
    color: #0a58ca;
    background-color: #e9ecef;
    border-color: #dee2e6;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}
</style>
@endpush
@endsection 