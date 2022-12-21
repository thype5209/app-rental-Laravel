<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengguna>
 */
class PenggunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nik' => fake()->nik(),
            'nama' => fake()->name(),
            'alamat' => fake()->address(),
            'no_hp' => fake()->phoneNumber(),
            'no_hp_lain' => fake()->phoneNumber(),
            'pekerjaan' => fake()->jobTitle(),
            'tempat_lahir' => fake()->streetAddress(30),
            'tgl_lahir' => fake()->date(),
        ];
    }
}
