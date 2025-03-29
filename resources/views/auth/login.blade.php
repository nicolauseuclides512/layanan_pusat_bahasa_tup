<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Portal Layanan Pusat Bahasa TUP</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .input-group-text {
            background: none;
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="login-container">
    <!-- Logo -->
    <div class="text-center mb-3">
        <img src="https://via.placeholder.com/80" class="img-fluid" alt="Logo">
    </div>

    <h4 class="text-center mb-3 fw-bold">Portal Layanan Pusat Bahasa TUP</h4>

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    <!-- Login Form -->
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <!-- Email Input -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
        </div>

        <!-- Password Input -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                <span class="input-group-text toggle-password"><i class="bi bi-eye"></i></span>
            </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">Keep me logged in</label>
            </div>
            <a href="#" class="text-decoration-none">Forgot password?</a>
        </div>

        <!-- Sign In Button -->
        <button type="submit" class="btn btn-dark w-100">Sign in</button>

        <!-- Divider -->
        <div class="text-center my-3">
            <span class="text-muted">OR</span>
        </div>

        <!-- Register Link -->
        <p class="text-center">
            Not a member yet? <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Register now</a>
        </p>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle Password Visibility
    document.querySelector('.toggle-password').addEventListener('click', function () {
        let passwordField = document.getElementById('password');
        let icon = this.querySelector('i');
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordField.type = "password";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>

</body>
</html>
