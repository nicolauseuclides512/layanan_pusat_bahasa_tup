@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Dashboard Admin</h2>
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless w-auto">
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>: {{ auth('web')->user()->nama }}</td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td>: {{ auth('web')->user()->nip }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ auth('web')->user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>: Admin</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
