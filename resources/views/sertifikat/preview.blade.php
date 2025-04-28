@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Preview Sertifikat') }}</h5>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $sertifikat->gambar_sertifikat) }}" alt="Sertifikat" class="img-fluid">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>{{ __('Nilai Sertifikat') }}:</strong> {{ $sertifikat->nilai }}</p>
                            <p><strong>{{ __('Tanggal Ujian') }}:</strong> {{ $sertifikat->tanggal_ujian->format('d/m/Y') }}</p>
                            <p><strong>{{ __('Tanggal Kadaluarsa') }}:</strong> {{ $sertifikat->tanggal_kadaluarsa->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>{{ __('Lembaga Penyelenggara') }}:</strong> {{ $sertifikat->lembaga_penyelenggara }}</p>
                            <p><strong>{{ __('Status') }}:</strong> 
                                <span class="badge bg-{{ $sertifikat->status === 'valid' ? 'success' : ($sertifikat->status === 'invalid' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($sertifikat->status) }}
                                </span>
                            </p>
                            @if($sertifikat->alasan_penolakan)
                                <p><strong>{{ __('Alasan Penolakan') }}:</strong> {{ $sertifikat->alasan_penolakan }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .card-header {
        display: none;
    }
    .btn {
        display: none;
    }
}
</style>
@endsection 