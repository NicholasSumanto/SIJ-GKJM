<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendetaDidikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pendeta_didik')->insert([
            [
                'id_pendeta' => 1,
                'nama_pendeta_didik' => 'Michael Johnson',
                'jenjang' => 'S1',
                'sekolah' => 'Universitas Teologi',
                'tahun_lulus' => 2021,
                'keterangan' => 'Belajar di bawah bimbingan Pendeta 1',
                'ijazah' => 'Ijazah S1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_pendeta' => 3,
                'nama_pendeta_didik' => 'Emily Clark',
                'jenjang' => 'S2',
                'sekolah' => 'Sekolah Tinggi Teologi',
                'tahun_lulus' => 2020,
                'keterangan' => 'Belajar di bawah bimbingan Pendeta 3',
                'ijazah' => 'Ijazah S2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ]);
    }
}
