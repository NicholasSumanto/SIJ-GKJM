<?php

namespace Database\Factories;

use App\Models\AnggotaKeluarga;
use App\Models\Jemaat;
use App\Models\Keluarga;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnggotaKeluargaFactory extends Factory
{
    protected $model = AnggotaKeluarga::class;

    public function definition()
    {
        $isFromJemaat = $this->faker->boolean(70);

        $idKeluarga = random_int(1, 20);

        if ($isFromJemaat) {
            $jemaat = Jemaat::inRandomOrder()->first();
            return [
                'id_jemaat' => $jemaat ? $jemaat->id_jemaat : null,
                'id_keluarga' => $idKeluarga,
                'nama_anggota' => $jemaat ? $jemaat->nama_jemaat : $this->faker->name(),
                'id_status' => Status::where('keterangan_status', 'Aktif')->first()->id_status,
            ];
        } else {
            return [
                'id_jemaat' => null,
                'id_keluarga' => $idKeluarga,
                'nama_anggota' => $this->faker->name(),
                'id_status' => Status::where('keterangan_status', 'Bukan Jemaat')->first()->id_status,
            ];
        }
    }
}
