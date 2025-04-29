@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('List Mahasiswa') }}</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('mahasiswa.index') }}" method="GET" class="mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Cari Mahasiswa</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama atau NIM...">
                            </div>
                            <div class="col-md-4">
                                <label for="prodi" class="form-label">Filter Program Studi</label>
                                <select name="prodi" id="prodi" class="form-select">
                                    <option value="all" {{ request('prodi') === 'all' ? 'selected' : '' }}>Semua Program Studi</option>
                                    @foreach($programStudi as $ps)
                                        <option value="{{ $ps->id }}" {{ request('prodi') == $ps->id ? 'selected' : '' }}>
                                            {{ $ps->nama_program_studi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Header -->
                    <div class="row bg-light py-2 mb-2 rounded">
                        <div class="col-1 text-center fw-bold">No</div>
                        <div class="col-3 fw-bold">Nama</div>
                        <div class="col-2 fw-bold">NIM</div>
                        <div class="col-2 fw-bold">Program Studi</div>
                        <div class="col-3 fw-bold">Email</div>
                        <div class="col-1 fw-bold">Tanggal</div>
                    </div>

                    <!-- Content -->
                    @forelse($mahasiswa as $index => $mhs)
                        <div class="row py-2 border-bottom align-items-center">
                            <div class="col-1 text-center">{{ $index + 1 }}</div>
                            <div class="col-3">{{ $mhs->nama }}</div>
                            <div class="col-2">{{ $mhs->nim }}</div>
                            <div class="col-2">{{ $mhs->programStudi->nama_program_studi ?? '-' }}</div>
                            <div class="col-3">{{ $mhs->email }}</div>
                            <div class="col-1">{{ $mhs->created_at->format('d/m/Y') }}</div>
                        </div>
                    @empty
                        <div class="row">
                            <div class="col-12 text-center py-4">
                                {{ __('Tidak ada data mahasiswa yang ditemukan.') }}
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .row {
        margin-left: 0;
        margin-right: 0;
    }
    .col-1, .col-2, .col-3 {
        padding: 0.5rem;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .border-bottom {
        border-bottom: 1px solid #dee2e6;
    }
    .rounded {
        border-radius: 0.25rem;
    }
</style>
@endsection 