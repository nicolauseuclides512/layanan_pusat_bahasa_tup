<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eprt_khusus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pendaftaran');
            $table->dateTime('tanggal_buka');
            $table->dateTime('tanggal_tutup');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eprt_khusus');
    }
}; 