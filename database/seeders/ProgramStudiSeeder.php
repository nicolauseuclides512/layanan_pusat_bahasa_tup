<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ProgramStudiSeeder extends Seeder
{
    protected $programStudis = [
        [
            'kode_program_studi' => 'D3TT',
            'nama_program_studi' => 'D3 Teknik Telekomunikasi'
        ],
        [
            'kode_program_studi' => 'S1BD',
            'nama_program_studi' => 'S1 Bisnis Digital'
        ],
        [
            'kode_program_studi' => 'S1DK',
            'nama_program_studi' => 'S1 Desain Komunikasi Visual'
        ],
        [
            'kode_program_studi' => 'S1DP',
            'nama_program_studi' => 'S1 Desain Produk'
        ],
        [
            'kode_program_studi' => 'S1SE',
            'nama_program_studi' => 'S1 Rekayasa Perangkat Lunak'
        ],
        [
            'kode_program_studi' => 'S1DS',
            'nama_program_studi' => 'S1 Sains Data'
        ],
        [
            'kode_program_studi' => 'S1SI',
            'nama_program_studi' => 'S1 Sistem Informasi'
        ],
        [
            'kode_program_studi' => 'S1TB',
            'nama_program_studi' => 'S1 Teknik Biomedis'
        ],
        [
            'kode_program_studi' => 'S1TE',
            'nama_program_studi' => 'S1 Teknik Elektro'
        ],
        [
            'kode_program_studi' => 'S1TI',
            'nama_program_studi' => 'S1 Teknik Industri'
        ],
        [
            'kode_program_studi' => 'S1IF',
            'nama_program_studi' => 'S1 Teknik Informatika'
        ],
        [
            'kode_program_studi' => 'S1TL',
            'nama_program_studi' => 'S1 Teknik Logistik'
        ],
        [
            'kode_program_studi' => 'S1TT',
            'nama_program_studi' => 'S1 Teknik Telekomunikasi'
        ],
        [
            'kode_program_studi' => 'S1TP',
            'nama_program_studi' => 'S1 Teknologi Pangan'
        ],
    ];

    public function run()
    {
        try {
            foreach ($this->programStudis as $prodi) {
                ProgramStudi::updateOrCreate(
                    ['kode_program_studi' => $prodi['kode_program_studi']],
                    $prodi
                );
            }

            $this->command->info('Program Studi seeded successfully!');
        } catch (\Exception $e) {
            Log::error('Error seeding program studi: ' . $e->getMessage());
            $this->command->error('Error seeding program studi: ' . $e->getMessage());
        }
    }
}
