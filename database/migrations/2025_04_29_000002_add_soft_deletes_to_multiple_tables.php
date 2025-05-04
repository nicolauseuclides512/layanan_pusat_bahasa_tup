<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tambah soft delete ke tabel sertifikats
        Schema::table('sertifikats', function (Blueprint $table) {
            if (!Schema::hasColumn('sertifikats', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Tambah soft delete ke tabel notifikasis
        Schema::table('notifikasis', function (Blueprint $table) {
            if (!Schema::hasColumn('notifikasis', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Tambah soft delete ke tabel eprt_khusus
        Schema::table('eprt_khusus', function (Blueprint $table) {
            if (!Schema::hasColumn('eprt_khusus', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down()
    {
        // Hapus soft delete dari tabel sertifikats
        Schema::table('sertifikats', function (Blueprint $table) {
            if (Schema::hasColumn('sertifikats', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        // Hapus soft delete dari tabel notifikasis
        Schema::table('notifikasis', function (Blueprint $table) {
            if (Schema::hasColumn('notifikasis', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        // Hapus soft delete dari tabel eprt_khusus
        Schema::table('eprt_khusus', function (Blueprint $table) {
            if (Schema::hasColumn('eprt_khusus', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
}; 