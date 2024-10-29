<?php

namespace Database\Factories;

use App\Models\Majelis;
use App\Models\Jemaat;
use App\Models\Gereja;
use App\Models\JabatanMajelis;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class MajelisFactory extends Factory
{
    protected $model = Majelis::class;

    protected static $jabatanCounter = [
        1 => 0,
        2 => 0,
    ];

    private $churches = [
        'Gereja Kristus',
        'Gereja Injil',
        'Gereja Betlehem',
        'Gereja Harapan',
    ];

    public function definition()
    {
        do {
            $id_jabatan = JabatanMajelis::inRandomOrder()->first()->id_jabatan;
        } while (self::isJabatanLimitReached($id_jabatan));

        $tanggal_mulai = $this->faker->date();
        $tanggal_selesai = $this->faker->dateTimeBetween($tanggal_mulai, '+5 year')->format('Y-m-d');

        return [
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'nama_gereja' => array_rand($this->churches),
            'nama_majelis' => $this->faker->name(),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'id_jabatan' => $id_jabatan,
            'id_status' => Status::inRandomOrder()->first()->id_status,
            'no_sk' => 'SK-' . strtoupper(uniqid()),
            'berkas' => 'berkas/' . uniqid() . '.pdf',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    protected static function isJabatanLimitReached($id_jabatan)
    {

        if (in_array($id_jabatan, [1, 2])) {
            self::$jabatanCounter[$id_jabatan]++;


            if (self::$jabatanCounter[$id_jabatan] > 1) {
                return true;
            }
        }
        return false;
    }
}
