@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Dashboard Mahasiswa</h2>
                <!-- Profil Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless w-auto">
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>: {{ auth('mahasiswa')->user()->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>: {{ auth('mahasiswa')->user()->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <th>NIM</th>
                                <td>: {{ auth('mahasiswa')->user()->nim }}</td>
                            </tr>
                            <tr>
                                <th>Prodi</th>
                                <td>: {{ auth('mahasiswa')->user()->programStudi->nama_program_studi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>: {{ auth('mahasiswa')->user()->no_hp }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: {{ auth('mahasiswa')->user()->email }}</td>
                            </tr>
                        </table>
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
