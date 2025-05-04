<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sertifikat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mahasiswa_id',
        'jenis_sertifikat',
        'status',
        'status_nde',
        'alasan_penolakan',
        'file_path',
        'nilai',
        'nama_dokumen',
        'tanggal_ujian',
        'tanggal_berakhir',
        'lembaga_penyelenggara',
        'verified_by',
        'verified_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'tanggal_ujian' => 'datetime',
        'tanggal_berakhir' => 'datetime',
        'verified_at' => 'datetime'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }
}