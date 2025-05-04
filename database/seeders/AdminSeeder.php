<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admins = [
            [
                'nama' => 'Petrus Kerowe Goran',
                'email' => 'petruskgoran@telkomuniversity.ac.id',
                'password' => Hash::make('p3tru5bh5128!'),
                'nip' => '23850012',
            ],
            [
                'nama' => 'Nicolaus Euclides Wahyu Nugroho',
                'email' => 'nicolausn@telkomuniversity.ac.id',
                'password' => Hash::make('n1c0bh5128!'),
                'nip' => '24940004',
            ]
        ];

        foreach ($admins as $admin) {
            Admin::updateOrCreate(
                ['email' => $admin['email']],
                $admin
            );
        }
    }
}
