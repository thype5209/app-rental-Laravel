<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mobil>
 */
class MobilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $no = fake()->numerify('M-####');
        $nama1 = 'fotoMobil/' . $no . '.png';
        $nama2 = 'fotoMobil/' . $no . '.png';
        $nama3 = 'fotoMobil/' . $no . '.png';
        $nama4 = 'fotoMobil/' . $no . '.png';
        // UploadedFile::fake('png')->create('text.png')->storeAs('public', $nama1);
        // UploadedFile::fake('png')->create('text.png')->storeAs('public', $nama2);
        // UploadedFile::fake('png')->create('text.png')->storeAs('public', $nama3);
        // UploadedFile::fake('png')->create('text.png')->storeAs('public', $nama4);
        return [
            'unit' => fake()->numerify('Mobil-####'),
            'spesifikasi' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
            'nopol' => fake()->numerify('DD ### M'),
            'tahun' => fake()->year('-2 years'),
            'harga' => fake()->numberBetween('12000', '30000'),
            'foto1' => $nama1,
            'foto2' => $nama2,
            'foto3' => $nama3,
            'foto4' => $nama4,
            'status' => '2',
        ];
    }

}
