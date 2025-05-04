<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->string('no_hp', 20)->change();
        });
    }

    public function down()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->string('no_hp', 15)->change();
        });
    }
};
