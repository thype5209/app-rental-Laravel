<?php

namespace Database\Seeders;

use App\Models\Sewa;
use App\Models\Mobil;
use App\Models\WaktuSewa;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mobil::factory(10)->has(Sewa::factory()
            ->count(1)
            ->state(function (array $attributes, Mobil $mobil) {
                return [
                    'nopol' => $mobil->nopol,
                    'unit' => $mobil->unit,
                    'tahun' => $mobil->tahun,
                    'harga' => $mobil->harga,
                ];
            })->has(WaktuSewa::factory()->state(function (array $attributes, Sewa $sewa) {
                return [
                    'sewa_id' => $sewa->id,
                ];
            })))->create();
    }
}
