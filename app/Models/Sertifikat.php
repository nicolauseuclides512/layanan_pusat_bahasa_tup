<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'nama_sertifikat',
        'lembaga_penyelenggara',
        'tanggal_ujian',
        'tanggal_berakhir',
        'status',
        'file_path',
        'alasan_penolakan',
        'verified_at',
        'verified_by'
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