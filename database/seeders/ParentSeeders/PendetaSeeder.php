<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pendeta')->insert([
            [
                'nama_pendeta' => 'John Doe',
                'jenjang' => 'S1',
                'sekolah' => 'Universitas Kristen',
                'tahun_lulus' => 2015,
                'keterangan' => 'pelayanan di Gereja X',
                'ijazah' => 'Ijazah S1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pendeta' => 'Jane Smith',
                'jenjang' => 'S2',
                'sekolah' => 'Sekolah Tinggi Teologi',
                'tahun_lulus' => 2018,
                'keterangan' => 'Pelayanan di Gereja X',
                'ijazah' => 'Ijazah S2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pendeta' => 'Rina Maria',
                'jenjang' => 'S2',
                'sekolah' => 'Universitas Kristen',
                'tahun_lulus' => 2018,
                'keterangan' => 'Pelayanan di Gereja X',
                'ijazah' => 'Ijazah S2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ]);
    }
}
