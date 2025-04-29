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
                                    <th>Nama Dokumen</th>
                                    <th>Lembaga</th>
                                    <th>Nilai</th>
                                    <th>Tanggal Ujian</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Status</th>
                                    <th>Alasan Penolakan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sertifikats as $sertifikat)
                                    <tr>
                                        <td>{{ $sertifikat->nama_dokumen }}</td>
                                        <td>{{ $sertifikat->lembaga_penyelenggara }}</td>
                                        <td>{{ $sertifikat->nilai ?? '-' }}</td>
                                        <td>{{ $sertifikat->tanggal_ujian ? $sertifikat->tanggal_ujian->format('d F Y') : '-' }}</td>
                                        <td>{{ $sertifikat->tanggal_berakhir ? $sertifikat->tanggal_berakhir->format('d F Y') : '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $sertifikat->status === 'approved' ? 'success' : ($sertifikat->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($sertifikat->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $sertifikat->alasan_penolakan ?? '-' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('sertifikat.preview', $sertifikat) }}" class="btn btn-sm btn-outline-info" title="Preview Sertifikat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($sertifikat->status === 'pending' || $sertifikat->status === 'rejected')
                                                    <a href="{{ route('sertifikat.edit', $sertifikat) }}" class="btn btn-sm btn-outline-warning" title="Edit Sertifikat">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($sertifikat->status === 'pending')
                                                        <form action="{{ route('sertifikat.destroy', $sertifikat) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Sertifikat">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
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
