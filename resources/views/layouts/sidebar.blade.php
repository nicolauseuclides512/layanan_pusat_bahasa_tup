<div class="sidebar bg-light border-right" style="min-height: 100vh;">
    <div class="sidebar-header text-center py-4">
        <h5>Dashboard Admin</h5>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
                <a class="nav-link active" href="{{ route('dashboard.admin') }}">
                    <i class="bi bi-house-door"></i> Home
                </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('verifikasi.index') }}">
                <i class="bi bi-check-circle"></i> Verifikasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('laporan.index') }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('mahasiswa.index') }}">
                <i class="bi bi-people"></i> Data Mahasiswa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
