<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EprtKhusus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'eprt_khusus';

    protected $fillable = [
        'nama_pendaftaran',
        'tanggal_buka',
        'tanggal_tutup',
        'status'
    ];

    protected $casts = [
        'tanggal_buka' => 'datetime',
        'tanggal_tutup' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        // Set timezone default untuk Carbon
        date_default_timezone_set('Asia/Jakarta');
        Carbon::setLocale('id');
    }

    public function isOpen()
    {
        $now = Carbon::now('Asia/Jakarta');
        
        // Jika sudah melewati tanggal tutup
        if ($now->greaterThan($this->tanggal_tutup)) {
            if ($this->status === 'aktif') {
                $this->update(['status' => 'nonaktif']);
            }
            return false;
        }
        
        // Jika belum mencapai tanggal buka
        if ($now->lessThan($this->tanggal_buka)) {
            return false;
        }
        
        return true;
    }

    // Method untuk mengecek dan mengupdate status semua pendaftaran
    public static function updateAllStatus()
    {
        $now = Carbon::now('Asia/Jakarta');
        
        // Update status pendaftaran yang sudah lewat waktu tutup
        self::where('status', 'aktif')
            ->whereNull('deleted_at')
            ->where(function($query) use ($now) {
                $query->whereRaw("CONCAT(DATE(tanggal_tutup), ' ', TIME(tanggal_tutup)) < ?", [$now->format('Y-m-d H:i:s')]);
            })
            ->update(['status' => 'nonaktif']);

        // Update status pendaftaran yang masih dalam periode aktif
        self::where('status', 'nonaktif')
            ->whereNull('deleted_at')
            ->where(function($query) use ($now) {
                $query->whereRaw("CONCAT(DATE(tanggal_buka), ' ', TIME(tanggal_buka)) <= ?", [$now->format('Y-m-d H:i:s')])
                      ->whereRaw("CONCAT(DATE(tanggal_tutup), ' ', TIME(tanggal_tutup)) >= ?", [$now->format('Y-m-d H:i:s')]);
            })
            ->update(['status' => 'aktif']);
    }
} 