<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->foreignId('program_studi_id')
                  ->nullable()
                  ->constrained('program_studis')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropForeign(['program_studi_id']);
            $table->dropColumn('program_studi_id');
        });
    }
};
