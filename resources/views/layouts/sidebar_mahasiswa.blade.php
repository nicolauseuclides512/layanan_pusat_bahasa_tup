@if(auth()->guard('mahasiswa')->check())
    <div class="sidebar-heading bg-primary text-white p-3">
        <h5 class="mb-0">Dashboard Mahasiswa</h5>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active d-flex align-items-center py-3 px-4" href="{{ route('dashboard.mahasiswa') }}">
                <i class="bi bi-house-door me-3"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center py-3 px-4" href="{{ route('sertifikat.index') }}">
                <i class="bi bi-file-earmark-text me-3"></i> List Sertifikat
            </a>
        </li>
        <li class="nav-item border-top">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link text-danger d-flex align-items-center py-3 px-4 w-100">
                    <i class="bi bi-box-arrow-right me-3"></i> Logout
                </button>
            </form>
        </li>
    </ul>
@endif
