<?php

namespace Database\Factories;

use App\Models\Mobil;
use App\Models\Pengguna;
use App\Models\Sopir;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sewa>
 */
class SewaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sopir = Sopir::factory()->create();
        $pengguna = Pengguna::factory()->create();
        return [
            'jenis_sewa' => "lepas",
            'kode' => fake()->numerify('S###-#'),
            'nopol' => function (array $attributes) {
                return Mobil::find($attributes['nopol'])->nopol;
            },
            'unit' => function (array $attributes) {
                return Mobil::find($attributes['nopol'])->unit;
            },
            'tahun' => function (array $attributes) {
                return Mobil::find($attributes['nopol'])->tahun;
            },
            'harga_bulan' => 12000,
            'harga' => 12000,
            'nik' => $pengguna->nik,
            'sopir_id' => $sopir->id,
            'penanggung_jawab' => fake()->numberBetween(1,3),
            'tujuan' => fake()->streetAddress(),
            'jaminan' => fake()->randomElement(['--', 'KTP', 'SIM']),
            'denda' => '0',
            'pdf_url' => fake()->imageUrl(),
            'status' => fake()->randomElement(['Telat', 'Selesai','Sewa']),
        ];
    }
}
