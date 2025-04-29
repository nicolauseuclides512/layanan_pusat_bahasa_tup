@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Edit Sertifikat') }}</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('sertifikat.update', $sertifikat) }}" method="POST" enctype="multipart/form-data" class="form-container">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_dokumen" class="form-label">{{ __('Nama Dokumen') }}</label>
                                <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen', $sertifikat->nama_dokumen) }}" required>
                                @error('nama_dokumen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lembaga_penyelenggara" class="form-label">{{ __('Lembaga Penyelenggara') }}</label>
                                <input type="text" class="form-control @error('lembaga_penyelenggara') is-invalid @enderror" id="lembaga_penyelenggara" name="lembaga_penyelenggara" value="{{ old('lembaga_penyelenggara', $sertifikat->lembaga_penyelenggara) }}" required>
                                @error('lembaga_penyelenggara')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nilai" class="form-label">{{ __('Nilai') }}</label>
                                <input type="text" class="form-control @error('nilai') is-invalid @enderror" id="nilai" name="nilai" value="{{ old('nilai', $sertifikat->nilai) }}" required>
                                @error('nilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tanggal_ujian" class="form-label">{{ __('Tanggal Ujian') }}</label>
                                <input type="date" class="form-control @error('tanggal_ujian') is-invalid @enderror" id="tanggal_ujian" name="tanggal_ujian" value="{{ old('tanggal_ujian', $sertifikat->tanggal_ujian ? $sertifikat->tanggal_ujian->format('Y-m-d') : '') }}" required>
                                @error('tanggal_ujian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tanggal_berakhir" class="form-label">{{ __('Tanggal Kadaluarsa') }}</label>
                                <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', $sertifikat->tanggal_berakhir ? $sertifikat->tanggal_berakhir->format('Y-m-d') : '') }}" required>
                                @error('tanggal_berakhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="file_sertifikat" class="form-label">{{ __('File Sertifikat') }}</label>
                                <input type="file" class="form-control @error('file_sertifikat') is-invalid @enderror" id="file_sertifikat" name="file_sertifikat">
                                @error('file_sertifikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format yang didukung: PDF, JPG, PNG. Maksimal ukuran: 2MB</small>
                                @if($sertifikat->file_path)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $sertifikat->file_path) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Lihat File Saat Ini
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('Simpan Perubahan') }}
                                </button>
                                <a href="{{ route('sertifikat.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Kembali') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 