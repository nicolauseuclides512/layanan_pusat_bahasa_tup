<div class="modal fade" id="verifikasiModal{{ $sertifikat->id }}" tabindex="-1" aria-labelledby="verifikasiModalLabel{{ $sertifikat->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('verifikasi.update', $sertifikat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="verifikasiModalLabel{{ $sertifikat->id }}">Verifikasi Sertifikat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any() && session('showModal') == $sertifikat->id)
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="approved{{ $sertifikat->id }}" value="approved" required {{ old('status') === 'approved' ? 'checked' : '' }}>
                            <label class="form-check-label" for="approved{{ $sertifikat->id }}">
                                Disetujui
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="rejected{{ $sertifikat->id }}" value="rejected" required {{ old('status') === 'rejected' ? 'checked' : '' }}>
                            <label class="form-check-label" for="rejected{{ $sertifikat->id }}">
                                Ditolak
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alasan_penolakan{{ $sertifikat->id }}" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alasan_penolakan') is-invalid @enderror" id="alasan_penolakan{{ $sertifikat->id }}" name="alasan_penolakan" rows="3">{{ old('alasan_penolakan') }}</textarea>
                        @error('alasan_penolakan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">Alasan penolakan harus diisi jika status ditolak</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> 