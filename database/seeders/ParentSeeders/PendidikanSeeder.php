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
            ['nama_pendidikan' => 'SD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_pendidikan' => 'SMA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_pendidikan' => 'D1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_pendidikan' => 'D2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_pendidikan' => 'D3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_pendidikan' => 'S1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_pendidikan' => 'S2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama_pendidikan' => 'S3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
