<?php

namespace Database\Factories;

use App\Models\JemaatTitipan;
use App\Models\Wilayah;
use Illuminate\Database\Eloquent\Factories\Factory;

class JemaatTitipanFactory extends Factory
{
    protected $model = JemaatTitipan::class;

    private $churches = [
        'Gereja Kristus',
        'Gereja Injil',
        'Gereja Betlehem',
        'Gereja Harapan',
    ];

    public function definition()
    {
        return [
            'nama_jemaat' => $this->faker->name,
            'tanggal_titipan' => $this->faker->date(),
            'tanggal_selesai' => $this->faker->date(),
            'nama_gereja_asal' => $this->churches[array_rand($this->churches)],
            'nama_gereja_tujuan' => $this->churches[array_rand($this->churches)],
            'kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat_jemaat' => $this->faker->address,
            'titipan' => $this->faker->randomElement(['Masuk', 'Keluar']),
            'status_titipan' => $this->faker->randomElement(['Berproses', 'Selesai']),
            'surat' => 'titipan/' . uniqid() . '.pdf',
        ];
    }
}

