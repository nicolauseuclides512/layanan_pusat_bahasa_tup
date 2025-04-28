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
                                        <td>{{ $sertifikat->user->name }}</td>
                                        <td>{{ $sertifikat->user->nim }}</td>
                                        <td>{{ $sertifikat->user->programStudi->nama }}</td>
                                        <td>{{ $sertifikat->nilai }}</td>
                                        <td>{{ $sertifikat->tanggal_ujian->format('d/m/Y') }}</td>
                                        <td>{{ $sertifikat->tanggal_kadaluarsa->format('d/m/Y') }}</td>
                                        <td>{{ $sertifikat->lembaga_penyelenggara }}</td>
                                        <td>
                                            <span class="badge bg-{{ $sertifikat->status === 'valid' ? 'success' : ($sertifikat->status === 'invalid' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($sertifikat->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $sertifikat->alasan_penolakan ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('verifikasi.preview', $sertifikat) }}" class="btn btn-info btn-sm" target="_blank">
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
                                                            <div class="mb-3">
                                                                <label class="form-label">Status</label>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="status" id="valid{{ $sertifikat->id }}" value="valid" required>
                                                                    <label class="form-check-label" for="valid{{ $sertifikat->id }}">
                                                                        Valid
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="status" id="invalid{{ $sertifikat->id }}" value="invalid" required>
                                                                    <label class="form-check-label" for="invalid{{ $sertifikat->id }}">
                                                                        Tidak Valid
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="alasan_penolakan{{ $sertifikat->id }}" class="form-label">Alasan Penolakan</label>
                                                                <textarea class="form-control" id="alasan_penolakan{{ $sertifikat->id }}" name="alasan_penolakan" rows="3"></textarea>
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