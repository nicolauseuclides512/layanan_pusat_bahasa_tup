@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ isset($mahasiswa) ? 'Edit Mahasiswa' : 'Tambah Mahasiswa' }}</h4>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($mahasiswa) ? route('mahasiswa.update', $mahasiswa->id) : route('mahasiswa.store') }}" 
                          method="POST" 
                          id="formMahasiswa">
                        @csrf
                        @if(isset($mahasiswa))
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $mahasiswa->nama ?? '') }}" 
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nim') is-invalid @enderror" 
                                       id="nim" 
                                       name="nim" 
                                       value="{{ old('nim', $mahasiswa->nim ?? '') }}" 
                                       required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="program_studi_id" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <select class="form-select @error('program_studi_id') is-invalid @enderror" 
                                        id="program_studi_id" 
                                        name="program_studi_id" 
                                        required>
                                    <option value="">Pilih Program Studi</option>
                                    @foreach($programStudi as $prodi)
                                        <option value="{{ $prodi->id }}" 
                                                {{ old('program_studi_id', $mahasiswa->program_studi_id ?? '') == $prodi->id ? 'selected' : '' }}>
                                            {{ $prodi->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('program_studi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $mahasiswa->email ?? '') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                <input type="tel" 
                                       class="form-control @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" 
                                       name="no_hp" 
                                       value="{{ old('no_hp', $mahasiswa->no_hp ?? '') }}" 
                                       required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <hr class="my-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> 
                                    {{ isset($mahasiswa) ? 'Update' : 'Simpan' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-info-circle text-info"></i> 
                        Instruksi Pengisian
                    </h5>
                    <div class="alert alert-light">
                        <ul class="mb-0">
                            <li>Semua field yang bertanda <span class="text-danger">*</span> wajib diisi</li>
                            <li>NIM harus unik dan terdiri dari angka</li>
                            <li>Email harus valid dan aktif</li>
                            <li>No. HP harus valid (format: 08xx-xxxx-xxxx)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('formMahasiswa');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // Phone number formatting
    const phoneInput = document.getElementById('no_hp');
    phoneInput.addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,4})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : !x[3] ? x[1] + '-' + x[2] : x[1] + '-' + x[2] + '-' + x[3];
    });
});
</script>
@endpush
@endsection 