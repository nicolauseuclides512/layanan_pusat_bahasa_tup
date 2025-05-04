@extends('layouts.guest')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: #fff;">
    <div class="card shadow" style="width: 400px; border-radius: 20px;">
        <div class="card-header text-center" style="background: #900; border-top-left-radius: 20px; border-top-right-radius: 20px;">
            <div class="text-white mt-2" style="font-size: 14px; font-weight: 600; line-height: 1.2;">
                PUSAT BAHASA<br>
                Telkom University Purwokerto
            </div>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="{{ asset('img/Logo Pusat Bahasa TUP.png') }}" alt="Logo" class="logo-navbar" style="height:80px;">
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <input type="email" name="email" class="form-control rounded-pill @error('email') is-invalid @enderror" placeholder="email" required autofocus>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control rounded-pill @error('password') is-invalid @enderror" placeholder="password" required>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-danger w-100 rounded-pill mb-2" style="font-weight: 600;">SIGN IN</button>
            </form>
            <div class="text-center mb-2">
                <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size: 14px;">Forgot Password?</a>
            </div>
            <div class="text-center" style="font-size: 14px;">
                Don't have an account?<br>
                <a href="{{ route('register') }}" class="fw-bold text-danger text-decoration-none">REGISTER NOW</a>
            </div>
        </div>
    </div>
</div>
@endsection