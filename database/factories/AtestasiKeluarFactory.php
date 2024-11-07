<?php

namespace Database\Factories;

use App\Models\AtestasiKeluar;
use App\Models\Jemaat;
use App\Models\Wilayah;
use App\Models\Pendeta;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtestasiKeluarFactory extends Factory
{
    protected $model = AtestasiKeluar::class;

    private $churches = [
        'Gereja Kristus',
        'Gereja Injil',
        'Gereja Betlehem',
        'Gereja Harapan',
    ];

    public function definition()
    {
        return [
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'id_wilayah' => Wilayah::inRandomOrder()->first()->id_wilayah,
            'id_pendeta' => Pendeta::inRandomOrder()->first()->id_pendeta,
            'nama_gereja' => $this->churches[array_rand($this->churches)],
            'no_surat' => $this->faker->unique()->numerify('SK-####'),
            'tanggal' => $this->faker->date(),
            'keterangan' => $this->faker->sentence,
        ];
    }
}
