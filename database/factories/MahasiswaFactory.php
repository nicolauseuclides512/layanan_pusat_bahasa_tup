<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'no_hp' => $this->faker->phoneNumber(),
            'nim' => $this->faker->unique()->numerify('##########'),
            'program_studi_id' => null,
        ];
    }
}
