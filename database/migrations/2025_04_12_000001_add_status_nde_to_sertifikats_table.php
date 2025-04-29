<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->enum('status_nde', ['belum_terkirim', 'terkirim'])->default('belum_terkirim')->after('status');
        });
    }

    public function down()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropColumn('status_nde');
        });
    }
}; 