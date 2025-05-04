@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ isset($sertifikat) ? __('Edit Sertifikat') : __('Tambah Sertifikat') }}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ isset($sertifikat) ? route('sertifikat.update', $sertifikat) : route('sertifikat.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($sertifikat))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="gambar_sertifikat" class="form-label">{{ __('Gambar Sertifikat') }} <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('gambar_sertifikat') is-invalid @enderror" id="gambar_sertifikat" name="gambar_sertifikat" accept="image/*" required>
                            @error('gambar_sertifikat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                        </div>

                        <div class="mb-3">
                            <label for="nilai" class="form-label">{{ __('Nilai') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('nilai') is-invalid @enderror" id="nilai" name="nilai" value="{{ old('nilai', $sertifikat->nilai ?? '') }}" min="0" max="700" required>
                            @error('nilai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_ujian" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Ujian') }}</label>
                            <div class="col-md-6">
                                <input id="tanggal_ujian" type="date" class="form-control @error('tanggal_ujian') is-invalid @enderror" name="tanggal_ujian" value="{{ old('tanggal_ujian', isset($sertifikat) && $sertifikat->tanggal_ujian ? $sertifikat->tanggal_ujian->format('Y-m-d') : '') }}" required>
                                @error('tanggal_ujian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tanggal_kadaluarsa" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Kadaluarsa') }}</label>
                            <div class="col-md-6">
                                <input id="tanggal_kadaluarsa" type="date" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa', isset($sertifikat) && $sertifikat->tanggal_berakhir ? $sertifikat->tanggal_berakhir->format('Y-m-d') : '') }}" required>
                                @error('tanggal_kadaluarsa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lembaga_penyelenggara" class="col-md-4 col-form-label text-md-end">{{ __('Lembaga Penyelenggara') }}</label>
                            <div class="col-md-6">
                                <input id="lembaga_penyelenggara" type="text" class="form-control @error('lembaga_penyelenggara') is-invalid @enderror" name="lembaga_penyelenggara" value="{{ old('lembaga_penyelenggara', $sertifikat->lembaga_penyelenggara ?? '') }}" required>
                                @error('lembaga_penyelenggara')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($sertifikat) ? __('Update') : __('Simpan') }}
                                </button>
                                <a href="{{ route('sertifikat.index') }}" class="btn btn-secondary">
                                    {{ __('Kembali') }}
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