<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class TestMahasiswaSeeder extends Seeder
{
    public function run()
    {
        $programStudis = ProgramStudi::all();
        $credentials = [];

        for ($i = 1; $i <= 10; $i++) {
            $email = "mahasiswa{$i}@example.com";
            $password = "password{$i}";

            Mahasiswa::create([
                'nama' => "Mahasiswa {$i}",
                'email' => $email,
                'password' => bcrypt($password),
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'nim' => rand(1000000000, 9999999999),
                'program_studi_id' => $programStudis->random()->id
            ]);

            $credentials[] = [
                'email' => $email,
                'password' => $password
            ];
        }

        $this->command->info('Test mahasiswa accounts created:');
        $this->command->table(['Email', 'Password'], $credentials);
    }
}
