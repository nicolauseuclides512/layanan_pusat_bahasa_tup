<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar-custom {
            min-width: 260px;
            max-width: 260px;
            min-height: 100vh;
            background: #f5f5f5;
            color: #222;
        }
        .sidebar-custom .sidebar-heading {
            background: #f5f5f5;
            color: #222;
            padding: 24px 20px 12px 20px;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .sidebar-custom .nav-link {
            color: #222;
            font-weight: 500;
        }
        .sidebar-custom .nav-link.active, .sidebar-custom .nav-link:focus, .sidebar-custom .nav-link:hover {
            background: #900;
            color: #fff;
        }
        .sidebar-custom .nav-link.text-danger {
            color: #ff4d4f !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #900; min-height: 60px;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="#">
                <img src="{{ asset('img/logo-telkom.png') }}" alt="Logo" style="height: 38px; margin-right: 12px;">
                <span class="d-none d-md-inline" style="font-size: 20px; letter-spacing: 1px;">PusatBahasa</span>
            </a>
            <div class="d-flex align-items-center ms-auto">
                <span class="text-white fw-semibold" style="font-size: 16px;">
                    Institut Teknologi Telkom Purwokerto
                </span>
            </div>
        </div>
    </nav>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar-custom">
            @include('layouts.sidebar_mahasiswa')
        </div>
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
