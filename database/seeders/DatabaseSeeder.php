<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProgramStudiSeeder::class,
            TestMahasiswaSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
