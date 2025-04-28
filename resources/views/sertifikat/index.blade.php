@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">List Sertifikat</h5>
                    <a href="{{ route('sertifikat.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus me-1"></i> Tambah Sertifikat
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nilai Sertifikat</th>
                                    <th>Tanggal Ujian</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Lembaga Penyelenggara</th>
                                    <th>Status</th>
                                    <th>Alasan Penolakan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sertifikats as $sertifikat)
                                    <tr>
                                        <td>{{ $sertifikat->nilai }}</td>
                                        <td>{{ $sertifikat->tanggal_ujian->format('d/m/Y') }}</td>
                                        <td>{{ $sertifikat->tanggal_kadaluarsa->format('d/m/Y') }}</td>
                                        <td>{{ $sertifikat->lembaga_penyelenggara }}</td>
                                        <td>
                                            <span class="badge bg-{{ $sertifikat->status === 'valid' ? 'success' : ($sertifikat->status === 'invalid' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($sertifikat->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $sertifikat->alasan_penolakan ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('sertifikat.preview', $sertifikat) }}" class="btn btn-info btn-sm" target="_blank">
                                                <i class="fas fa-eye"></i> Preview
                                            </a>
                                            @if(in_array($sertifikat->status, ['valid', 'invalid']))
                                                <a href="{{ route('sertifikat.preview', $sertifikat) }}?print=1" class="btn btn-secondary btn-sm" target="_blank">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                            @endif
                                            @if($sertifikat->status === 'pending')
                                                <a href="{{ route('sertifikat.edit', $sertifikat) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('sertifikat.destroy', $sertifikat) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada sertifikat yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
