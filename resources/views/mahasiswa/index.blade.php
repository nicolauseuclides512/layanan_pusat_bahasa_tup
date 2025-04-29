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

                    <form action="{{ route('mahasiswa.index') }}" method="GET" class="mb-3">
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

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('No') }}</th>
                                    <th>{{ __('Nama') }}</th>
                                    <th>{{ __('NIM') }}</th>
                                    <th>{{ __('Program Studi') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Tanggal Registrasi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mahasiswa as $index => $mhs)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $mhs->nama }}</td>
                                        <td>{{ $mhs->nim }}</td>
                                        <td>{{ $mhs->programStudi->nama_program_studi ?? '-' }}</td>
                                        <td>{{ $mhs->email }}</td>
                                        <td>{{ $mhs->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('Tidak ada data mahasiswa yang ditemukan.') }}</td>
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