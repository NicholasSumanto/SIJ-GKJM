<?php

namespace Database\Factories;

use App\Models\Keluarga;
use App\Models\Jemaat;
use App\Models\Wilayah;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeluargaFactory extends Factory
{
    protected $model = Keluarga::class;

    public function definition()
    {
        return [
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'kepala_keluarga' => Jemaat::inRandomOrder()->first()->nama_jemaat,
            'id_wilayah' => Wilayah::inRandomOrder()->first()->id_wilayah,
        ];
    }
}
