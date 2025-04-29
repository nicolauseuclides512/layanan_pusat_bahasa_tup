@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
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

                    <form action="{{ route('verifikasi.index') }}" method="GET" class="mb-3">
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
                                    <th>{{ __('Nama Mahasiswa') }}</th>
                                    <th>{{ __('NIM') }}</th>
                                    <th>{{ __('Prodi') }}</th>
                                    <th>{{ __('Nilai Sertifikat') }}</th>
                                    <th>{{ __('Tanggal Ujian') }}</th>
                                    <th>{{ __('Tanggal Kadaluarsa') }}</th>
                                    <th>{{ __('Lembaga Penyelenggara') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Status NDE') }}</th>
                                    <th>{{ __('Alasan Penolakan') }}</th>
                                    <th class="text-center">{{ __('Aksi') }}</th>
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
                                        <td>{{ $sertifikat->alasan_penolakan ?? '-' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('verifikasi.preview', $sertifikat) }}" class="btn btn-info btn-sm" title="Preview Sertifikat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($sertifikat->status === 'pending')
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasiModal{{ $sertifikat->id }}" title="Verifikasi Sertifikat">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    @if($sertifikat->status === 'pending')
                                        <div class="modal fade" id="verifikasiModal{{ $sertifikat->id }}" tabindex="-1" aria-labelledby="verifikasiModalLabel{{ $sertifikat->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('verifikasi.update', $sertifikat) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="verifikasiModalLabel{{ $sertifikat->id }}">Verifikasi Sertifikat</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if($errors->any() && session('showModal') == $sertifikat->id)
                                                                <div class="alert alert-danger">
                                                                    <ul class="mb-0">
                                                                        @foreach($errors->all() as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                            <div class="mb-3">
                                                                <label class="form-label">Status</label>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="status" id="approved{{ $sertifikat->id }}" value="approved" required {{ old('status') === 'approved' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="approved{{ $sertifikat->id }}">
                                                                        Disetujui
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="status" id="rejected{{ $sertifikat->id }}" value="rejected" required {{ old('status') === 'rejected' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="rejected{{ $sertifikat->id }}">
                                                                        Ditolak
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="alasan_penolakan{{ $sertifikat->id }}" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                                <textarea class="form-control @error('alasan_penolakan') is-invalid @enderror" id="alasan_penolakan{{ $sertifikat->id }}" name="alasan_penolakan" rows="3">{{ old('alasan_penolakan') }}</textarea>
                                                                @error('alasan_penolakan')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                                <small class="text-muted">Alasan penolakan harus diisi jika status ditolak</small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($sertifikat->status === 'approved')
                                        <div class="modal fade" id="updateNdeModal{{ $sertifikat->id }}" tabindex="-1" aria-labelledby="updateNdeModalLabel{{ $sertifikat->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('sertifikat.update-nde', $sertifikat) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateNdeModalLabel{{ $sertifikat->id }}">Update Status NDE</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Status NDE</label>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="status_nde" id="belum_terkirim{{ $sertifikat->id }}" value="belum_terkirim" {{ $sertifikat->status_nde === 'belum_terkirim' ? 'checked' : '' }} required>
                                                                    <label class="form-check-label" for="belum_terkirim{{ $sertifikat->id }}">
                                                                        Belum Terkirim
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="status_nde" id="terkirim{{ $sertifikat->id }}" value="terkirim" {{ $sertifikat->status_nde === 'terkirim' ? 'checked' : '' }} required>
                                                                    <label class="form-check-label" for="terkirim{{ $sertifikat->id }}">
                                                                        Terkirim
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">{{ __('Tidak ada sertifikat yang ditemukan.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
