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
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Email" autofocus>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="nim_nip" type="text" class="form-control rounded-pill @error('nim_nip') is-invalid @enderror" name="nim_nip" value="{{ old('nim_nip') }}" required placeholder="NIM atau NIP">
                    @error('nim_nip')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="name" type="text" class="form-control rounded-pill @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap">
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required placeholder="Password Baru">
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="password_confirmation" type="password" class="form-control rounded-pill" name="password_confirmation" required placeholder="Konfirmasi Password Baru">
                </div>
                <button type="submit" class="btn btn-danger w-100 rounded-pill mb-2" style="font-weight: 600;">RESET PASSWORD</button>
            </form>
            <div class="text-center" style="font-size: 14px;">
                <a href="{{ route('login') }}" class="fw-bold text-danger text-decoration-none">Kembali ke Login</a>
            </div>
        </div>
    </div>
</div>
@endsection 