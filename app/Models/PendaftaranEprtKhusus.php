<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranEprtKhusus extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_eprt_khusus';
    protected $fillable = [
        'mahasiswa_id',
        'eprt_khusus_id',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function eprtKhusus()
    {
        return $this->belongsTo(EprtKhusus::class);
    }
}
