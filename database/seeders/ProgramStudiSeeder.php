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
            'nama_program_studi' => 'D3 Teknik Telekomunikasi',
            'jenjang' => 'D3',
            'fakultas' => 'Fakultas Teknik Elektro',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1BD',
            'nama_program_studi' => 'S1 Bisnis Digital',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Ekonomi dan Bisnis',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1DK',
            'nama_program_studi' => 'S1 Desain Komunikasi Visual',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Industri Kreatif',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1DP',
            'nama_program_studi' => 'S1 Desain Produk',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Industri Kreatif',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1SE',
            'nama_program_studi' => 'S1 Rekayasa Perangkat Lunak',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Informatika',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1DS',
            'nama_program_studi' => 'S1 Sains Data',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Informatika',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1SI',
            'nama_program_studi' => 'S1 Sistem Informasi',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Rekayasa Industri',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1TB',
            'nama_program_studi' => 'S1 Teknik Biomedis',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Teknik Elektro',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1TE',
            'nama_program_studi' => 'S1 Teknik Elektro',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Teknik Elektro',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1TI',
            'nama_program_studi' => 'S1 Teknik Industri',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Rekayasa Industri',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1IF',
            'nama_program_studi' => 'S1 Teknik Informatika',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Informatika',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1TL',
            'nama_program_studi' => 'S1 Teknik Logistik',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Rekayasa Industri',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1TT',
            'nama_program_studi' => 'S1 Teknik Telekomunikasi',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Teknik Elektro',
            'status' => 'active'
        ],
        [
            'kode_program_studi' => 'S1TP',
            'nama_program_studi' => 'S1 Teknologi Pangan',
            'jenjang' => 'S1',
            'fakultas' => 'Fakultas Rekayasa Industri',
            'status' => 'active'
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
