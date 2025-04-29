@if(auth()->guard('mahasiswa')->check())
    <div class="sidebar-heading">Dashboard Mahasiswa</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard.mahasiswa') ? 'active' : '' }}" href="{{ route('dashboard.mahasiswa') }}">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('sertifikat.*') ? 'active' : '' }}" href="{{ route('sertifikat.index') }}">
                <i class="fas fa-list"></i> List Sertifikat
            </a>
        </li>
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-link text-danger" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </li>
    </ul>
@endif
