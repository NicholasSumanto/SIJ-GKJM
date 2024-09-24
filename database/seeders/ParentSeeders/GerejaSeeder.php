<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GerejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gereja')->insert([
            ['nama_gereja' => 'Gereja Kristus', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_gereja' => 'Gereja Injil', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_gereja' => 'Gereja Betlehem', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_gereja' => 'Gereja Harapan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
