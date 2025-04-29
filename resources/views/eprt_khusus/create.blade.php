@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Tambah EPrT Khusus') }}</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('eprt-khusus.store') }}" method="POST" class="form-container">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="nama_pendaftaran" class="form-label">{{ __('Nama Pendaftaran') }}</label>
                                <input type="text" class="form-control @error('nama_pendaftaran') is-invalid @enderror" id="nama_pendaftaran" name="nama_pendaftaran" value="{{ old('nama_pendaftaran') }}" required>
                                @error('nama_pendaftaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_buka" class="form-label">{{ __('Tanggal Buka') }}</label>
                                <input type="date" class="form-control @error('tanggal_buka') is-invalid @enderror" id="tanggal_buka" name="tanggal_buka" value="{{ old('tanggal_buka') }}" required>
                                @error('tanggal_buka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Jam Buka') }}</label>
                                <div class="row">
                                    <div class="col-6">
                                        <select class="form-select @error('jam_buka') is-invalid @enderror" name="jam_buka" required>
                                            <option value="">Pilih Jam</option>
                                            @for($i = 0; $i < 24; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ old('jam_buka') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('jam_buka')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select @error('menit_buka') is-invalid @enderror" name="menit_buka" required>
                                            <option value="">Pilih Menit</option>
                                            @for($i = 0; $i < 60; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ old('menit_buka') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('menit_buka')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_tutup" class="form-label">{{ __('Tanggal Tutup') }}</label>
                                <input type="date" class="form-control @error('tanggal_tutup') is-invalid @enderror" id="tanggal_tutup" name="tanggal_tutup" value="{{ old('tanggal_tutup') }}" required>
                                @error('tanggal_tutup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Jam Tutup') }}</label>
                                <div class="row">
                                    <div class="col-6">
                                        <select class="form-select @error('jam_tutup') is-invalid @enderror" name="jam_tutup" required>
                                            <option value="">Pilih Jam</option>
                                            @for($i = 0; $i < 24; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ old('jam_tutup') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('jam_tutup')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select @error('menit_tutup') is-invalid @enderror" name="menit_tutup" required>
                                            <option value="">Pilih Menit</option>
                                            @for($i = 0; $i < 60; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ old('menit_tutup') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('menit_tutup')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('Simpan') }}
                                </button>
                                <a href="{{ route('eprt-khusus.index') }}" class="btn btn-secondary">
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