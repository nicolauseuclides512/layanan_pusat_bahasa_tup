<div class="modal fade" id="updateNdeModal{{ $sertifikat->id }}" tabindex="-1" aria-labelledby="updateNdeModalLabel{{ $sertifikat->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('sertifikat.update-nde', $sertifikat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateNdeModalLabel{{ $sertifikat->id }}">Update Status NDE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status NDE</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_nde" id="belum_terkirim{{ $sertifikat->id }}" value="belum_terkirim" {{ $sertifikat->status_nde === 'belum_terkirim' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="belum_terkirim{{ $sertifikat->id }}">
                                Belum Terkirim
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_nde" id="terkirim{{ $sertifikat->id }}" value="terkirim" {{ $sertifikat->status_nde === 'terkirim' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="terkirim{{ $sertifikat->id }}">
                                Terkirim
                            </label>
                        </div>
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