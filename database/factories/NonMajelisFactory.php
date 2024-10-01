<?php

namespace Database\Factories;

use App\Models\NonMajelis;
use App\Models\Jemaat;
use App\Models\Gereja;
use App\Models\JabatanNonMajelis;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class NonMajelisFactory extends Factory
{
    protected $model = NonMajelis::class;


    public function definition()
    {
        $tanggal_mulai = $this->faker->date();
        $tanggal_selesai = $this->faker->dateTimeBetween($tanggal_mulai, '+5 year')->format('Y-m-d');

        return [
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'id_gereja' => Gereja::inRandomOrder()->first()->id_gereja,
            'nama_majelis_non' => $this->faker->name(),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'id_jabatan_non' => JabatanNonMajelis::inRandomOrder()->first()->id_jabatan_non,
            'id_status' => Status::inRandomOrder()->first()->id_status,
            'no_sk' => 'SK-' . strtoupper(uniqid()),
            'berkas' => 'berkas/' . uniqid() . '.pdf',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
