<?php

namespace Database\Factories;

use App\Models\BaptisDewasa;
use App\Models\Pendeta;
use App\Models\Wilayah;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BaptisDewasaFactory extends Factory
{
    protected $model = BaptisDewasa::class;

    public function definition(): array
    {
        return [
            'id_wilayah' => Wilayah::inRandomOrder()->first()->id_wilayah,
            'id_pendeta' => Pendeta::inRandomOrder()->first()->id_pendeta,
            'nomor' => 'BD-' . $this->faker->unique()->numberBetween(100, 999),
            'nama' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'ayah' => $this->faker->name('male'),
            'ibu' => $this->faker->name('female'),
            'tanggal_baptis' => Carbon::now()->subYears(rand(1, 10)),
            'ketua_majelis' => $this->faker->name(),
            'sekretaris_majelis' => $this->faker->name(),
        ];
    }
}
