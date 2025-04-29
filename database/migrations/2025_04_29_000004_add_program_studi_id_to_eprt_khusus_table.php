<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('eprt_khusus', function (Blueprint $table) {
            $table->foreignId('program_studi_id')->nullable()->after('status')
                  ->constrained('program_studis')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('eprt_khusus', function (Blueprint $table) {
            $table->dropForeign(['program_studi_id']);
            $table->dropColumn('program_studi_id');
        });
    }
}; 