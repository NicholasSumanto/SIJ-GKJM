<?php

namespace Database\Factories;

use App\Models\Jemaat;
use App\Models\Keluarga;
use App\Models\KeluargaDetil;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeluargaDetilFactory extends Factory
{
    protected $model = KeluargaDetil::class;

    public function definition()
    {
        return [
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'id_keluarga' => Keluarga::inRandomOrder()->first()->id_keluarga,
        ];
    }
}
