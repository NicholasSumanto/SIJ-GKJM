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


    protected static $familyMembers = [];

    public function definition()
    {
        $isFromJemaat = $this->faker->boolean(70);
        $idKeluarga = random_int(1, 20);

        $kepalaKeluarga = Keluarga::where('id_keluarga', $idKeluarga)->first();

        if (!isset(self::$familyMembers[$idKeluarga])) {
            self::$familyMembers[$idKeluarga] = [
                'Suami' => ($kepalaKeluarga && $kepalaKeluarga->keterangan_hubungan === 'Suami'),
                'Istri' => ($kepalaKeluarga && $kepalaKeluarga->keterangan_hubungan === 'Istri')
            ];
        }

        if (!self::$familyMembers[$idKeluarga]['Suami']) {
            $keteranganHubungan = 'Suami';
            self::$familyMembers[$idKeluarga]['Suami'] = true;
        } elseif (!self::$familyMembers[$idKeluarga]['Istri']) {
            $keteranganHubungan = 'Istri';
            self::$familyMembers[$idKeluarga]['Istri'] = true;
        } else {
            $keteranganHubungan = 'Anak';
        }

        // Tambahkan definisi untuk $namaAnggota
        $namaAnggota = $this->faker->name;

        if ($isFromJemaat) {
            $jemaat = Jemaat::inRandomOrder()->first();
            return [
                'id_jemaat' => $jemaat ? $jemaat->id_jemaat : null,
                'id_keluarga' => $idKeluarga,
                'nama_anggota' => $namaAnggota,
                'keterangan_hubungan' => $keteranganHubungan,
            ];
        } else {
            return [
                'id_jemaat' => null,
                'id_keluarga' => $idKeluarga,
                'nama_anggota' => $namaAnggota,
                'keterangan_hubungan' => $keteranganHubungan,
            ];
        }
    }
}
