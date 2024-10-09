<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            ['keterangan_status' => 'Aktif', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['keterangan_status' => 'Meninggal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['keterangan_status' => 'Bukan Jemaat', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['keterangan_status' => 'Keluar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['keterangan_status' => 'Titipan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['keterangan_status' => 'Pending', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
