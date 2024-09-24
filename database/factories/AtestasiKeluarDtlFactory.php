<?php

namespace Database\Factories;

use App\Models\AtestasiKeluarDtl;
use App\Models\Jemaat;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtestasiKeluarDtlFactory extends Factory
{
    protected $model = AtestasiKeluarDtl::class;

    public function definition()
    {
        return [
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'keterangan' => $this->faker->sentence,
        ];
    }
}
