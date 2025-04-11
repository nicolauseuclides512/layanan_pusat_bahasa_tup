@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Reset Password</h2>
                <form action="{{ route('reset.password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Student ID (NIM)</label>
                        <input type="text" class="form-control" id="nim" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                    <p class="text-center mt-3">
                        Back to Login? <a href="{{ route('login') }}">Sign in</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
