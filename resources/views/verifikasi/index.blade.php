@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Verifikasi Sertifikat</h2>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sertifikat</th>
                            <th>Lembaga Penyelenggara</th>
                            <th>Tanggal Ujian</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sertifikats as $sertifikat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sertifikat->nama_sertifikat }}</td>
                            <td>{{ $sertifikat->lembaga_penyelenggara }}</td>
                            <td>{{ $sertifikat->tanggal_ujian->format('d/m/Y') }}</td>
                            <td>{{ $sertifikat->tanggal_berakhir->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge 
                                    @if($sertifikat->status == 'valid') badge-success
                                    @elseif($sertifikat->status == 'ditolak') badge-danger
                                    @else badge-warning @endif">
                                    {{ ucfirst($sertifikat->status) }}
                                </span>
                                @if($sertifikat->status == 'ditolak' && $sertifikat->alasan_penolakan)
                                    <small class="d-block text-muted">Alasan: {{ $sertifikat->alasan_penolakan }}</small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ asset('storage/' . $sertifikat->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                    Lihat
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('verifikasi.updateStatus', $sertifikat->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <select name="status" class="form-control form-control-sm" onchange="toggleReasonField(this)">
                                            <option value="pending" {{ $sertifikat->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="valid" {{ $sertifikat->status == 'valid' ? 'selected' : '' }}>Valid</option>
                                            <option value="ditolak" {{ $sertifikat->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2" id="reasonField" style="display: none;">
                                        <input type="text" name="alasan_penolakan" class="form-control form-control-sm" 
                                            placeholder="Alasan penolakan" value="{{ $sertifikat->alasan_penolakan ?? '' }}" required>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleReasonField(select) {
        const reasonField = document.getElementById('reasonField');
        reasonField.style.display = select.value === 'ditolak' ? 'block' : 'none';
        if (select.value === 'ditolak') {
            reasonField.querySelector('input').required = true;
        } else {
            reasonField.querySelector('input').required = false;
        }
    }
    
    // Initialize reason field visibility on page load
    document.addEventListener('DOMContentLoaded', function() {
        const initialSelect = document.querySelector('select[name="status"]');
        if (initialSelect) {
            toggleReasonField(initialSelect);
        }
    });
</script>
@endsection