@extends('layouts.guest')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: #fff;">
    <div class="card shadow" style="width: 450px; border-radius: 20px;">
        <div class="card-header text-center" style="background: #900; border-top-left-radius: 20px; border-top-right-radius: 20px;">
            <img src="{{ asset('img/logo-telkom.png') }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
            <div class="text-white mt-2" style="font-size: 14px; font-weight: 600; line-height: 1.2;">
                PUSAT BAHASA<br>
                Institut Teknologi<br>
                Telkom Purwokerto
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <input id="name" type="text" class="form-control rounded-pill @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap" autofocus required>
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label d-block mb-2">Jenis Kelamin</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkL" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="jkL">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkP" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="jkP">Perempuan</label>
                    </div>
                    @error('jenis_kelamin')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="nim" type="text" class="form-control rounded-pill @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim') }}" required placeholder="NIM" required>
                    @error('nim')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <select id="program_studi_id" class="form-control rounded-pill @error('program_studi_id') is-invalid @enderror" name="program_studi_id" required>
                        <option value="" disabled {{ old('program_studi_id') ? '' : 'selected' }}>Pilih Program Studi</option>
                        @foreach($programStudis as $programStudi)
                            <option value="{{ $programStudi->id }}" {{ old('program_studi_id') == $programStudi->id ? 'selected' : '' }}>
                                {{ $programStudi->nama_program_studi }}
                            </option>
                        @endforeach
                    </select>
                    @error('program_studi_id')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="no_telepon" type="text" class="form-control rounded-pill @error('no_telepon') is-invalid @enderror" name="no_telepon" value="{{ old('no_telepon') }}" required placeholder="No. Telepon" required>
                    @error('no_telepon')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Email" required>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required placeholder="Password" required>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="password_confirmation" type="password" class="form-control rounded-pill" name="password_confirmation" required placeholder="Konfirmasi Password" required>
                </div>
                <button type="submit" class="btn btn-danger w-100 rounded-pill mb-2" style="font-weight: 600;">REGISTER</button>
            </form>
            <div class="text-center mb-2">
                <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size: 14px;">Forgot Password?</a>
            </div>
            <div class="text-center" style="font-size: 14px;">
                Sudah punya akun?<br>
                <a href="{{ route('login') }}" class="fw-bold text-danger text-decoration-none">LOGIN</a>
            </div>
        </div>
    </div>
</div>
@endsection
