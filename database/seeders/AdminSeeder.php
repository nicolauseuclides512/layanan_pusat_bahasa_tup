<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admins = [
            [
                'nama' => 'Petrus Kerowe Goran',
                'email' => 'petruskgoran@telkomuniversity.ac.id',
                'password' => 'p3tru5bh5128!',
                'nip' => '23850012',
                'role' => 'admin',
                'status' => 'active'
            ],
            [
                'nama' => 'Nicolaus Euclides Wahyu Nugroho',
                'email' => 'nicolausn@telkomuniversity.ac.id',
                'password' => 'n1c0bh5128!',
                'nip' => '24940004',
                'role' => 'admin',
                'status' => 'active'
            ]
        ];

        try {
            foreach ($admins as $admin) {
                User::updateOrCreate(
                    ['email' => $admin['email']],
                    [
                        'name' => $admin['nama'],
                        'password' => Hash::make($admin['password']),
                        'nip' => $admin['nip'],
                        'role' => $admin['role'],
                        'status' => $admin['status']
                    ]
                );
            }

            $this->command->info('Admin users seeded successfully!');
        } catch (\Exception $e) {
            Log::error('Error seeding admin users: ' . $e->getMessage());
            $this->command->error('Error seeding admin users: ' . $e->getMessage());
        }
    }
}
