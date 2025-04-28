<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L', 'P'])->after('nim');
        });
    }

    public function down()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
        });
    }
}; 