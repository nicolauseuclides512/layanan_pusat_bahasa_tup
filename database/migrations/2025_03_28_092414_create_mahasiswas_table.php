<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_hp', 15);
            $table->string('nim', 20)->unique();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('mahasiswas');
    }
};
