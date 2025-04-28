<div class="sidebar-heading">Dashboard Admin</div>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}" href="{{ route('dashboard.admin') }}">
            <i class="bi bi-house"></i> Home
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('verifikasi.*') ? 'active' : '' }}" href="{{ route('verifikasi.index') }}">
            <i class="bi bi-check2-square"></i> List Sertifikat
        </a>
    </li>
    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="nav-link text-danger" type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>
    </li>
</ul> 