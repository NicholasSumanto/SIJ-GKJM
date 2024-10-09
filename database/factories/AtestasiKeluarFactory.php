<?php

namespace Database\Factories;

use App\Models\AtestasiKeluar;
use App\Models\Jemaat;
use App\Models\Wilayah;
use App\Models\Gereja;
use App\Models\Pendeta;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtestasiKeluarFactory extends Factory
{
    protected $model = AtestasiKeluar::class;

    public function definition()
    {
        return [
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'id_wilayah' => Wilayah::inRandomOrder()->first()->id_wilayah,
            'id_pendeta' => Pendeta::inRandomOrder()->first()->id_pendeta,
            'id_gereja' => Gereja::inRandomOrder()->first()->id_gereja,
            'no_surat' => $this->faker->unique()->numerify('SK-####'),
            'tanggal' => $this->faker->date(),
            'keterangan' => $this->faker->sentence,
        ];
    }
}
