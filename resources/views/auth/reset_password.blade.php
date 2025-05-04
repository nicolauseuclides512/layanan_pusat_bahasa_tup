@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reset Password</h1>
    <form method="POST" action="{{ route('reset.password') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
    </form>
</div>
@endsection
