@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Sertifikat</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sertifikat.update', $sertifikat) }}" method="POST" enctype="multipart/form-data" class="form-container">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="lembaga_penyelenggara" class="form-label">Lembaga Penyelenggara</label>
                                <input type="text" class="form-control @error('lembaga_penyelenggara') is-invalid @enderror" id="lembaga_penyelenggara" name="lembaga_penyelenggara" value="{{ old('lembaga_penyelenggara', $sertifikat->lembaga_penyelenggara) }}" required>
                                @error('lembaga_penyelenggara')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nilai" class="form-label">Nilai</label>
                                <input type="number" step="0.01" min="0" max="700" class="form-control @error('nilai') is-invalid @enderror" id="nilai" name="nilai" value="{{ old('nilai', $sertifikat->nilai) }}" required>
                                @error('nilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_ujian" class="form-label">Tanggal Ujian</label>
                                <input type="date" class="form-control @error('tanggal_ujian') is-invalid @enderror" id="tanggal_ujian" name="tanggal_ujian" value="{{ old('tanggal_ujian', $sertifikat->tanggal_ujian ? $sertifikat->tanggal_ujian->format('Y-m-d') : '') }}" required>
                                @error('tanggal_ujian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                                <input type="date" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa', $sertifikat->tanggal_berakhir ? $sertifikat->tanggal_berakhir->format('Y-m-d') : '') }}" required>
                                @error('tanggal_kadaluarsa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="gambar_sertifikat" class="form-label">Gambar Sertifikat</label>
                                @if($sertifikat->file_path)
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            File saat ini:
                                            <a href="{{ asset('storage/' . $sertifikat->file_path) }}" target="_blank" class="text-primary text-decoration-underline">
                                                {{ $sertifikat->nama_dokumen }}
                                            </a>
                                        </small>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('gambar_sertifikat') is-invalid @enderror" id="gambar_sertifikat" name="gambar_sertifikat" accept="image/jpeg,image/png">
                                @error('gambar_sertifikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format yang didukung: JPG, PNG. Maksimal ukuran: 2MB. Biarkan kosong jika tidak ingin mengubah file.</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('sertifikat.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
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