<?php

namespace Database\Factories;

use App\Models\AtestasiMasuk;
use App\Models\Wilayah;
use App\Models\Jemaat;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtestasiMasukFactory extends Factory
{
    protected $model = AtestasiMasuk::class;

    private $churches = [
        'Gereja Kristus',
        'Gereja Injil',
        'Gereja Betlehem',
        'Gereja Harapan',
    ];

    public function definition()
    {
        return [
            'id_wilayah' => Wilayah::inRandomOrder()->first()->id_wilayah,
            'nama_gereja' => $this->churches[array_rand($this->churches)],
            'nama_masuk' => $this->faker->name(),
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'no_surat' => $this->faker->unique()->numerify('SM-####'),
            'tanggal_masuk' => $this->faker->date(),
            'surat' => $this->faker->sentence,
        ];
    }
}
