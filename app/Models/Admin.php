<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'password', 'nip'];
    protected $hidden = ['password']; // Menyembunyikan password saat query

    public function notifikasis(): HasMany {
        return $this->hasMany(Notifikasi::class);
    }
}
