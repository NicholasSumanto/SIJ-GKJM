<?php

namespace Database\Factories;

use App\Models\AtestasiKeluarDtl;
use App\Models\Jemaat;
use App\Models\AtestasiKeluar;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtestasiKeluarDtlFactory extends Factory
{
    protected $model = AtestasiKeluarDtl::class;

    public function definition()
    {
        return [
            'id_keluar' => AtestasiKeluar::inRandomOrder()->first()->id_keluar,
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'keterangan' => $this->faker->sentence,
        ];
    }
}
