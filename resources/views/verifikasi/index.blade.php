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

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Nilai</th>
                                    <th>Tanggal Ujian</th>
                                    <th>Kadaluarsa</th>
                                    <th>Lembaga</th>
                                    <th>Status</th>
                                    <th>Status NDE</th>
                                    <th style="min-width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sertifikats as $sertifikat)
                                <tr>
                                    <td>{{ $sertifikat->mahasiswa ? $sertifikat->mahasiswa->nama : '-' }}</td>
                                    <td>{{ $sertifikat->mahasiswa ? $sertifikat->mahasiswa->nim : '-' }}</td>
                                    <td>{{ $sertifikat->mahasiswa && $sertifikat->mahasiswa->programStudi ? $sertifikat->mahasiswa->programStudi->nama_program_studi : '-' }}</td>
                                    <td>{{ $sertifikat->nilai }}</td>
                                    <td>{{ $sertifikat->tanggal_ujian ? $sertifikat->tanggal_ujian->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $sertifikat->tanggal_berakhir ? $sertifikat->tanggal_berakhir->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $sertifikat->lembaga_penyelenggara }}</td>
                                    <td>
                                        <span class="badge bg-{{ $sertifikat->status === 'approved' ? 'success' : ($sertifikat->status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($sertifikat->status) }}
                                        </span>
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="{{ route('verifikasi.preview', $sertifikat) }}" class="btn btn-info btn-sm" title="Preview">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($sertifikat->status !== 'approved')
                                            <form action="{{ route('sertifikat.destroy', $sertifikat) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Modal Update NDE Status -->
                                @if($sertifikat->status === 'approved')
                                <div class="modal fade" id="updateNdeModal{{ $sertifikat->id }}" tabindex="-1" aria-labelledby="updateNdeModalLabel{{ $sertifikat->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateNdeModalLabel{{ $sertifikat->id }}">Update Status NDE</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('sertifikat.update-nde', $sertifikat) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="status_nde" class="form-label">Status NDE</label>
                                                        <select name="status_nde" id="status_nde" class="form-select" required>
                                                            <option value="belum_terkirim" {{ $sertifikat->status_nde === 'belum_terkirim' ? 'selected' : '' }}>Belum Terkirim</option>
                                                            <option value="terkirim" {{ $sertifikat->status_nde === 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada sertifikat yang ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <x-pagination-control :items="$sertifikats" />
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