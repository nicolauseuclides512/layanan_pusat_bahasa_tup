<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'nama' => 'Petrus Kerowe Goran',
            'email' => 'petruskgoran@telkomuniversity.ac.id',
            'password' => Hash::make('p3tru5bh5128!'), 
            'nip' => '23850012'
        ]);

        Admin::create([
            'nama' => 'Nicolaus Euclides Wahyu Nugroho',
            'email' => 'nicolausn@telkomuniversity.ac.id',
            'password' => Hash::make('n1c0bh5128!'),
            'nip' => '24940004'
        ]);
    }
}
