<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    protected $admins = [
        [
            'nama' => 'Petrus Kerowe Goran',
            'email' => 'petruskgoran@telkomuniversity.ac.id',
            'password' => 'p3tru5bh5128!',
            'nip' => '23850012',
            'role' => 'super_admin',
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

    public function run()
    {
        try {
            foreach ($this->admins as $admin) {
                Admin::updateOrCreate(
                    ['email' => $admin['email']],
                    array_merge($admin, [
                        'password' => Hash::make($admin['password']),
                        'email_verified_at' => now()
                    ])
                );
            }

            $this->command->info('Admin users seeded successfully!');
        } catch (\Exception $e) {
            Log::error('Error seeding admin users: ' . $e->getMessage());
            $this->command->error('Error seeding admin users: ' . $e->getMessage());
        }
    }
}
