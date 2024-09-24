<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JabatanNonMajelisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jabatan_nonmajelis')->insert([
            [
                'jabatan_nonmajelis' => 'Koordinator Gereja',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'jabatan_nonmajelis' => 'Pengurus Remaja',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'jabatan_nonmajelis' => 'Pengurus Komisi',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'jabatan_nonmajelis' => 'Pengurus Multi Media',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'jabatan_nonmajelis' => 'Pengurus Pemuda',
                'periode' => 2021,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ]);
    }
}
