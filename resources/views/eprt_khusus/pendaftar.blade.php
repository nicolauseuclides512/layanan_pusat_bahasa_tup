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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftar as $i => $p)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $p->mahasiswa->nama ?? '-' }}</td>
                                    <td>{{ $p->mahasiswa->nim ?? '-' }}</td>
                                    <td>{{ $p->mahasiswa->email ?? '-' }}</td>
                                    <td><span class="badge bg-{{ $p->status == 'pending' ? 'warning' : ($p->status == 'approved' ? 'success' : 'danger') }}">{{ ucfirst($p->status) }}</span></td>
                                    <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 