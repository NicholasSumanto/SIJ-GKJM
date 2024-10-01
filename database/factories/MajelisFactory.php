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

    // Store the counters for specific jabatan values
    protected static $jabatanCounter = [
        1 => 0, // Counter for jabatan id 1
        2 => 0, // Counter for jabatan id 2
    ];

    public function definition()
    {
        // Attempt to fetch a random id_jabatan
        do {
            $id_jabatan = JabatanMajelis::inRandomOrder()->first()->id_jabatan;
        } while (self::isJabatanLimitReached($id_jabatan));

        $tanggal_mulai = $this->faker->date();
        $tanggal_selesai = $this->faker->dateTimeBetween($tanggal_mulai, '+5 year')->format('Y-m-d');

        return [
            'id_jemaat' => Jemaat::inRandomOrder()->first()->id_jemaat,
            'id_gereja' => Gereja::inRandomOrder()->first()->id_gereja,
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
        // Check if the jabatan is 1 or 2 and increment the counter accordingly
        if (in_array($id_jabatan, [1, 2])) {
            self::$jabatanCounter[$id_jabatan]++;

            // If the counter exceeds 1, return true to indicate that the limit has been reached
            if (self::$jabatanCounter[$id_jabatan] > 1) {
                return true; // Limit reached
            }
        }
        return false; // Limit not reached
    }
}
