<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem; /* 14px */
            line-height: 1.5;
            color: #374151;
            background-color: #f8f9fa;
            padding-top: 56px; /* Height of navbar */
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            line-height: 1.25;
        }

        .card-title {
            font-size: 1.125rem; /* 18px */
            font-weight: 600;
        }

        .table {
            font-size: 0.875rem; /* 14px */
        }

        .btn {
            font-size: 0.875rem; /* 14px */
            font-weight: 500;
        }

        .form-label {
            font-size: 0.875rem; /* 14px */
            font-weight: 500;
        }

        .form-control {
            font-size: 0.875rem; /* 14px */
        }

        .badge {
            font-size: 0.75rem; /* 12px */
            font-weight: 500;
        }

        .nav-link {
            font-size: 0.875rem; /* 14px */
            font-weight: 500;
        }

        .sidebar-heading {
            font-size: 0.75rem; /* 12px */
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .alert {
            font-size: 0.875rem; /* 14px */
        }

        .modal-title {
            font-size: 1.125rem; /* 18px */
            font-weight: 600;
        }

        .form-text {
            font-size: 0.75rem; /* 12px */
        }

        /* Sidebar Custom Styling */
        .sidebar-custom {
            min-width: 260px;
            max-width: 260px;
            min-height: calc(100vh - 56px); /* Subtract navbar height */
            background: #f5f5f5;
            color: #222;
            position: fixed;
            top: 56px; /* Height of navbar */
            left: 0;
            overflow-y: auto;
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

        .sidebar-custom .nav-link.active, 
        .sidebar-custom .nav-link:focus, 
        .sidebar-custom .nav-link:hover {
            background: #900;
            color: #fff;
        }

        .sidebar-custom .nav-link.text-danger {
            color: #ff4d4f !important;
        }

        /* Navbar Fixed */
        .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px; /* Width of sidebar */
            padding: 20px;
            width: calc(100% - 260px);
        }

        /* Form Styling */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Card Styling */
        .card {
            margin-bottom: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 1rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Table Styling */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        /* Button Styling */
        .btn-group-sm > .btn, .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        /* Modal Styling */
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }

        .modal-content {
            border-radius: 0.3rem;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
            padding: 1rem;
        }

        .modal-body {
            padding: 1rem;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 1rem;
        }
    </style>

    @stack('styles')
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

        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
