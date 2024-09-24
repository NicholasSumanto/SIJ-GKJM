<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BidangIlmuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bidangilmu')->insert([
            ['bidangilmu' => 'Hukum', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['bidangilmu' => 'Teknik', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['bidangilmu' => 'Ekonomi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['bidangilmu' => 'Politik', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['bidangilmu' => 'Kesehatan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
