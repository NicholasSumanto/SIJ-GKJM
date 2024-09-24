<?php

namespace Database\Factories;

use App\Models\AtestasiMasuk;
use App\Models\Wilayah;
use App\Models\Gereja;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtestasiMasukFactory extends Factory
{
    protected $model = AtestasiMasuk::class;

    public function definition()
    {
        return [
            'id_wilayah' => Wilayah::inRandomOrder()->first()->id_wilayah,
            'id_gereja' => Gereja::inRandomOrder()->first()->id_gereja,
            'no_surat' => $this->faker->unique()->numerify('SM-####'),
            'tanggal' => $this->faker->date(),
            'surat' => $this->faker->sentence,
        ];
    }
}
