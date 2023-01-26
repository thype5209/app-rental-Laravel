<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\Sopir;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sopir::factory(10)->create();
        Pengguna::factory(10000)->create();
    }
}
