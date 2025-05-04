@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Jadwal EPrT Khusus Aktif</h3>
    @if($registrations->isEmpty())
        <div class="alert alert-info">Belum ada jadwal EPrT Khusus yang aktif.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pendaftaran</th>
                        <th>Tanggal Buka</th>
                        <th>Tanggal Tutup</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $i => $reg)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $reg->nama_pendaftaran }}</td>
                            <td>{{ \Carbon\Carbon::parse($reg->tanggal_buka)->format('d M Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reg->tanggal_tutup)->format('d M Y H:i') }}</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection 