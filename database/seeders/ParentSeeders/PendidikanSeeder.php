<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pendidikan')->insert([
            ['pendidikan' => 'SD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pendidikan' => 'SMA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pendidikan' => 'D1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pendidikan' => 'D2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pendidikan' => 'D3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pendidikan' => 'S1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pendidikan' => 'S2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['pendidikan' => 'S3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
