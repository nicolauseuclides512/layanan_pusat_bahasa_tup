<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('reset_password_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('token');
            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('reset_password_tokens');
    }
};
