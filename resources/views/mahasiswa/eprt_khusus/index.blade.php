@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Jadwal EPrT Khusus Aktif</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $pendaftaranSaya = \App\Models\PendaftaranEprtKhusus::where('mahasiswa_id', auth('mahasiswa')->id())->get()->keyBy('eprt_khusus_id');
                    @endphp
                    @foreach($registrations as $i => $reg)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $reg->nama_pendaftaran }}</td>
                            <td>{{ \Carbon\Carbon::parse($reg->tanggal_buka)->format('d M Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reg->tanggal_tutup)->format('d M Y H:i') }}</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td>
                                @if(isset($pendaftaranSaya[$reg->id]))
                                    <span class="badge bg-info">Sudah daftar ({{ ucfirst($pendaftaranSaya[$reg->id]->status) }})</span>
                                @else
                                    <form action="{{ route('pendaftaran_eprt_khusus.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="eprt_khusus_id" value="{{ $reg->id }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Daftar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection 