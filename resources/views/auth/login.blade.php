@extends('layouts.auth')

@section('title', 'Login - Portal Pusat Bahasa TUP')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="text-center">Welcome back</h2>
                        <p class="text-center">Please enter your details to sign in</p>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Sign in</button>
                        </form>
                        <p class="text-center mt-3">
                            <a href="{{ route('reset.password.form') }}">Forgot password?</a>
                        </p>
                        <p class="text-center">
                            Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
