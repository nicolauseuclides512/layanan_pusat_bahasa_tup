<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->date('tanggal_ujian');
            $table->date('tanggal_berakhir')->nullable();
            $table->string('lembaga_penyelenggara');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('file_path')->nullable()->after('status');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('sertifikats');
    }
};
