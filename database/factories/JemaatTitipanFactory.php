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
            'nama_gereja' => $this->churches[array_rand($this->churches)],
            'kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat_jemaat' => $this->faker->address,
            'titipan' => $this->faker->randomElement(['Masuk', 'Keluar']),
            'surat' => 'titipan/' . uniqid() . '.pdf',
        ];
    }
}

