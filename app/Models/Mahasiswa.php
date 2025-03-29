<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'password', 'no_hp', 'nim'];
    protected $hidden = ['password']; // Menyembunyikan password saat query
    protected $casts = ['email_verified_at' => 'datetime']; // Jika ada verifikasi email

    public function sertifikats(): HasMany {
        return $this->hasMany(Sertifikat::class);
    }

    public function notifikasis(): HasMany {
        return $this->hasMany(Notifikasi::class);
    }
}
