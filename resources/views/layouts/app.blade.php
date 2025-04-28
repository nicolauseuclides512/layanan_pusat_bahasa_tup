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
    @if(auth('web')->check())
        @include('layouts.partials.navbar_admin')
    @elseif(auth('mahasiswa')->check())
        @include('layouts.partials.navbar_mahasiswa')
    @endif
    <div class="d-flex">
        <!-- Sidebar -->
        @if(auth('web')->check())
            <div class="sidebar-custom">
                @include('layouts.sidebar_admin')
            </div>
        @elseif(auth('mahasiswa')->check())
            <div class="sidebar-custom">
                @include('layouts.sidebar_mahasiswa')
            </div>
        @endif
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
