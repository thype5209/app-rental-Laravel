<?php

namespace Database\Factories;

use App\Models\Sewa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WaktuSewa>
 */
class WaktuSewaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $carbon = Carbon::parse(fake()->dateTimeThisMonth('-12 days'));
        $number = fake()->randomNumber(1,10);
        $carbon2 =    Carbon::now()->add($number,'day');
        return [
            'sewa_id' => function (array $attributes) {
                return Sewa::find($attributes['id'])->id;
            },
            'tgl_sewa' => $carbon,
            'jam_sewa' => "00:00:00",
            'tgl_kembali' => $carbon2,
            'jam_kembali' => "00:00:00",
            'lama_sewa' => $carbon->diffInDays($carbon2),
        ];
    }
}
