@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">List Sertifikat</h5>
                    <a href="{{ route('sertifikat.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus me-1"></i> Tambah Sertifikat
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Nilai Sertifikat</th>
                                    <th>Tanggal Ujian</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Lembaga Penyelenggara</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Status NDE') }}</th>
                                    <th>Alasan Penolakan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sertifikats as $sertifikat)
                                    <tr>
                                        <td>{{ $sertifikat->mahasiswa->nama ?? '-' }}</td>
                                        <td>{{ $sertifikat->mahasiswa->nim ?? '-' }}</td>
                                        <td>{{ $sertifikat->mahasiswa->programStudi->nama_program_studi ?? '-' }}</td>
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
                                            <a href="{{ route('sertifikat.preview', $sertifikat) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Preview
                                            </a>
                                            <a href="{{ route('sertifikat.edit', $sertifikat) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('sertifikat.destroy', $sertifikat) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
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
                                        <td colspan="10" class="text-center">Tidak ada sertifikat yang ditemukan.</td>
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
