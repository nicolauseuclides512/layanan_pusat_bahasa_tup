<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate all tables before seeding
        $this->truncateTables([
            'program_studis',
            'mahasiswas',
            'admins',
            'sertifikats'
        ]);

        // Run seeders in correct order
        $this->call([
            ProgramStudiSeeder::class,
            AdminSeeder::class,
            TestMahasiswaSeeder::class, // Only in development environment
        ]);

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
    }

    protected function truncateTables(array $tables)
    {
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }
}
