@extends('layouts.app')

@section('content')
<div class="container">
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
                            <div class="col-md-4">
                                <label for="status" class="form-label">Filter Status</label>
                                <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Nama Mahasiswa') }}</th>
                                    <th>{{ __('NIM') }}</th>
                                    <th>{{ __('Prodi') }}</th>
                                    <th>{{ __('Nilai Sertifikat') }}</th>
                                    <th>{{ __('Tanggal Ujian') }}</th>
                                    <th>{{ __('Tanggal Kadaluarsa') }}</th>
                                    <th>{{ __('Lembaga Penyelenggara') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Alasan Penolakan') }}</th>
                                    <th>{{ __('Aksi') }}</th>
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
                                        <td>{{ $sertifikat->alasan_penolakan ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('verifikasi.preview', $sertifikat) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Preview
                                            </a>
                                            @if($sertifikat->status === 'pending')
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasiModal{{ $sertifikat->id }}">
                                                    <i class="fas fa-check"></i> Verifikasi
                                                </button>
                                            @endif
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
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">{{ __('Tidak ada sertifikat yang ditemukan.') }}</td>
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
