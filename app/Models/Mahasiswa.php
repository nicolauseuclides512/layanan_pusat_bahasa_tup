<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email', 
        'password',
        'no_hp',
        'nim',
        'program_studi_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
