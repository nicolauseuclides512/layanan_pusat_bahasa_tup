@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('layouts.sidebar')
            </div>
            <div class="col-md-9">
                <h2>Dashboard</h2>
                <div class="card mb-4">
                    <div class="card-body">
                        <p><strong>Nama Lengkap:</strong> {{ auth()->user()->nama }}</p>
                        <p><strong>NIM:</strong> {{ auth()->user()->nim }}</p>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>Program Studi:</strong> {{ auth()->user()->program_studi }}</p>
                        <p><strong>Status:</strong> {{ auth()->user()->status }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
