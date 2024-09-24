<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pekerjaan')->insert([
            ['pekerjaan' => 'Pendeta', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pekerjaan' => 'Guru', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pekerjaan' => 'Pengusaha', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pekerjaan' => 'Dokter', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pekerjaan' => 'Politikus', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
