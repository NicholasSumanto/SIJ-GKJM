<?php

namespace Database\Factories;

use App\Models\Jemaat;
use App\Models\Gereja;
use App\Models\Pendeta;
use App\Models\Kematian;
use Illuminate\Database\Eloquent\Factories\Factory;

class KematianFactory extends Factory
{
    protected $model = Kematian::class;
    private $churches = [
        'Gereja Kristus',
        'Gereja Injil',
        'Gereja Betlehem',
        'Gereja Harapan',
    ];

    public function definition()
    {
        $tanggal_meninggal = $this->faker->dateTimeBetween('-2 years', 'now');
        $tanggal_pemakaman = $this->faker->dateTimeBetween($tanggal_meninggal, 'now');

        return [
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'nama_gereja' => array_rand($this->churches),
            'id_pendeta' => Pendeta::inRandomOrder()->first()->id_pendeta,
            'tanggal_meninggal' => $tanggal_meninggal->format('Y-m-d'),
            'tanggal_pemakaman' => $tanggal_pemakaman->format('Y-m-d'),
            'tempat_pemakaman' => $this->faker->city,
            'keterangan' => $this->faker->sentence,
        ];
    }
}
