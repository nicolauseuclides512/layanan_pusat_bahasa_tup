<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'nilai',
        'nama_dokumen',
        'file_path',
        'tanggal_ujian',
        'tanggal_berakhir',
        'lembaga_penyelenggara',
        'status',
        'alasan_penolakan',
        'status_nde',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'tanggal_ujian' => 'date',
        'tanggal_berakhir' => 'date',
        'verified_at' => 'datetime',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }
}