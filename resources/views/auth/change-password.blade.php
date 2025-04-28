@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh; background: #fff;">
    <div class="card shadow" style="width: 450px; border-radius: 20px;">
        <div class="card-header text-center" style="background: #900; border-top-left-radius: 20px; border-top-right-radius: 20px;">
            <span class="text-white fw-bold" style="font-size: 20px;">Change Password</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="mb-3">
                    <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email', auth('mahasiswa')->user()->email ?? auth('web')->user()->email) }}" required readonly>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id="current_password" type="password" class="form-control rounded-pill @error('current_password') is-invalid @enderror" name="current_password" required placeholder="Password Lama">
                    @error('current_password')
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
                <button type="submit" class="btn btn-danger w-100 rounded-pill mb-2" style="font-weight: 600;">CHANGE PASSWORD</button>
            </form>
        </div>
    </div>
</div>
@endsection 