<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TestMahasiswaSeeder extends Seeder
{
    public function run()
    {
        if (!app()->environment('local', 'development')) {
            $this->command->warn('Test mahasiswa seeder should only run in development environment!');
            return;
        }

        try {
            $programStudis = ProgramStudi::all();
            $credentials = [];

            for ($i = 1; $i <= 10; $i++) {
                $email = "mahasiswa{$i}@example.com";
                $password = "password{$i}";
                $nim = date('y') . str_pad($i, 8, '0', STR_PAD_LEFT);

                $mahasiswa = Mahasiswa::create([
                    'nama' => "Mahasiswa Test {$i}",
                    'email' => $email,
                    'password' => Hash::make($password),
                    'no_hp' => '08' . rand(1000000000, 9999999999),
                    'nim' => $nim,
                    'program_studi_id' => $programStudis->random()->id,
                    'status' => 'active',
                    'email_verified_at' => now()
                ]);

                $credentials[] = [
                    'nama' => $mahasiswa->nama,
                    'nim' => $nim,
                    'email' => $email,
                    'password' => $password
                ];
            }

            $this->command->info('Test mahasiswa accounts created:');
            $this->command->table(
                ['Nama', 'NIM', 'Email', 'Password'],
                $credentials
            );

        } catch (\Exception $e) {
            Log::error('Error seeding test mahasiswa: ' . $e->getMessage());
            $this->command->error('Error seeding test mahasiswa: ' . $e->getMessage());
        }
    }
}
