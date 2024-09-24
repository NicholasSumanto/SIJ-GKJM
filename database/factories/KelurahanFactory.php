<?php

namespace Database\Factories;

use App\Models\Kelurahan;
use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelurahanFactory extends Factory
{
    protected $model = Kelurahan::class;

    public function definition()
    {
        return [
            'id_kecamatan' => Kecamatan::inRandomOrder()->first()->id_kecamatan,
            'kelurahan' => $this->faker->word,
        ];
    }
}

