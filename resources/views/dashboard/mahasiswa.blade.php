@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('layouts.sidebar')
            </div>
            <div class="col-md-9">
                <h2 class="mb-4">Dashboard Mahasiswa</h2>
                
                <!-- Profil Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-muted">Nama Lengkap</h6>
                                    <p class="h5">{{ auth()->user()->nama }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="text-muted">NIM</h6>
                                    <p class="h5">{{ auth()->user()->nim }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-muted">Program Studi</h6>
                                    <p class="h5">
                                        {{ auth()->user()->programStudi->nama_program_studi ?? 'Belum dipilih' }}
                                        ({{ auth()->user()->programStudi->kode_program_studi ?? '' }})
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="text-muted">Status</h6>
                                    <p class="h5">{{ auth()->user()->status }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-user-edit me-2"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
