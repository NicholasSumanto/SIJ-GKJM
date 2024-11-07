<?php

namespace Database\Factories;

use App\Models\Pernikahan;
use App\Models\Pendeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pernikahan>
 */
class PernikahanFactory extends Factory
{
    protected $model = Pernikahan::class;
    private $churches = [
        'Gereja Kristus',
        'Gereja Injil',
        'Gereja Betlehem',
        'Gereja Harapan',
    ];

    public function definition(): array
    {
        return [
            'nomor' => $this->faker->unique()->numerify('PNK###'),
            'nama_gereja' =>$this->churches[array_rand($this->churches)],
            'tanggal_nikah' => $this->faker->date(),
            'id_pendeta' => Pendeta::inRandomOrder()->first()->id_pendeta,
            'pengantin_pria' => $this->faker->name(),
            'pengantin_wanita' => $this->faker->name(),
            'ayah_pria' => $this->faker->name(),
            'ibu_pria' => $this->faker->name(),
            'ayah_wanita' => $this->faker->name(),
            'ibu_wanita' => $this->faker->name(),
            'saksi1' => $this->faker->name(),
            'saksi2' => $this->faker->name(),
            'warga' => $this->faker->randomElement(['Warga Jemaat', 'Bukan Warga']),
            'tempat' => $this->faker->address(),
            'ketua_majelis' => $this->faker->name(),
            'sekretaris_majelis' => $this->faker->name(),
        ];
    }
}
