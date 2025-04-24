<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'nama_dokumen',
        'file_path', 
        'tanggal_ujian',
        'tanggal_berakhir',
        'lembaga_penyelenggara',
        'status',
        'alasan_penolakan'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
