<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResetPasswordToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token', 'expired_at'];

    protected $casts = [
        'expired_at' => 'datetime'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(Mahasiswa::class, 'user_id')->orWhereBelongsTo(Admin::class, 'user_id');
    }
}
