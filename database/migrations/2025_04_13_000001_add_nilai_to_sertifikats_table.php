<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->integer('nilai')->after('file_path');
        });
    }

    public function down()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropColumn('nilai');
        });
    }
}; 