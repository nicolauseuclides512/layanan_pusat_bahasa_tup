@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h4 class="mb-0">Pendaftar EPrT Khusus: <b>{{ $eprtKhusus->nama_pendaftaran }}</b></h4>
            <a href="{{ route('eprt_khusus.index') }}" class="btn btn-secondary mt-2"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($pendaftar->isEmpty())
                <div class="alert alert-info">Belum ada mahasiswa yang mendaftar pada jadwal ini.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>NIM</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftar as $i => $p)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>
                                        <a href="{{ route('mahasiswa.show', $p->mahasiswa->id) }}" class="text-decoration-none">
                                            {{ $p->mahasiswa->nama ?? '-' }}
                                        </a>
                                    </td>
                                    <td>{{ $p->mahasiswa->nim ?? '-' }}</td>
                                    <td>{{ $p->mahasiswa->email ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $p->status == 'pending' ? 'warning' : ($p->status == 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        @if($p->status == 'pending')
                                            <form action="{{ route('pendaftaran-eprt-khusus.validate', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-success btn-sm" title="Terima">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('pendaftaran-eprt-khusus.validate', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">Sudah divalidasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if(alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 500);
        }
    }, 2500);
    // Konfirmasi validasi dengan SweetAlert
    const validationForms = document.querySelectorAll('form[action*="validate"]');
    validationForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const action = this.querySelector('input[name="status"]').value === 'approved' ? 'menerima' : 'menolak';
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan ${action} pendaftaran mahasiswa ini.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: action === 'menerima' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Ya, ${action}`,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
@endsection 