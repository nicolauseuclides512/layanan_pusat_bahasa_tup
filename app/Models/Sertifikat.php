<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'nama_sertifikat',
        'lembaga_penyelenggara',
        'tanggal_ujian',
        'tanggal_berakhir',
        'status',
        'alasan_penolakan',
        'file_path'
    ];

    protected $casts = [
        'tanggal_ujian' => 'date',
        'tanggal_berakhir' => 'date',
        'status' => 'string'
    ];

    public function mahasiswa(): BelongsTo {
        return $this->belongsTo(Mahasiswa::class);
    }
}
