<?php

namespace Database\Factories;

use App\Models\Kabupaten;
use App\Models\Provinsi;
use Illuminate\Database\Eloquent\Factories\Factory;

class KabupatenFactory extends Factory
{
    protected $model = Kabupaten::class;

    public function definition()
    {
        return [
            'id_provinsi' => Provinsi::inRandomOrder()->first()->id_provinsi,
            'kabupaten' => $this->faker->word,
        ];
    }
}

