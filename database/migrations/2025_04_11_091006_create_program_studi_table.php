<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('program_studis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_program_studi', 10)->unique();
            $table->string('nama_program_studi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_studis');
    }
};
