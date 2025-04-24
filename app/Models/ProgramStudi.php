<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_program_studi', 
        'nama_program_studi'
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
