<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JabatanMajelisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jabatan_majelis')->insert([
            [
                'jabatan_majelis' => 'Ketua Majelis',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'jabatan_majelis' => 'Wakil Ketua Majelis',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'jabatan_majelis' => 'Sekretaris Majelis',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'jabatan_majelis' => 'Bendahara Majelis',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'jabatan_majelis' => 'Anggota Majelis',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
