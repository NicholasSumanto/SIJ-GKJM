<?php

namespace Database\Seeders\ParentSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wilayah')->insert([
            [
                'nama_wilayah' => 'Wilayah 1',
                'alamat_wilayah' => 'Jl. Wilayah 1 No.1',
                'kota_wilayah' => 'Kota A',
                'email_wilayah' => 'wilayah1@contoh.com',
                'telepon_wilayah' => '081234567890',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_wilayah' => 'Wilayah 2',
                'alamat_wilayah' => 'Jl. Wilayah 2 No.2',
                'kota_wilayah' => 'Kota B',
                'email_wilayah' => 'wilayah2@contoh.com',
                'telepon_wilayah' => '081234567891',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_wilayah' => 'Wilayah 3',
                'alamat_wilayah' => 'Jl. Wilayah 3 No.3',
                'kota_wilayah' => 'Kota C',
                'email_wilayah' => 'wilayah3@contoh.com',
                'telepon_wilayah' => '081234567892',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_wilayah' => 'Wilayah 4',
                'alamat_wilayah' => 'Jl. Wilayah 4 No.4',
                'kota_wilayah' => 'Kota D',
                'email_wilayah' => 'wilayah4@contoh.com',
                'telepon_wilayah' => '081234567893',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_wilayah' => 'Wilayah 5',
                'alamat_wilayah' => 'Jl. Wilayah 5 No.5',
                'kota_wilayah' => 'Kota E',
                'email_wilayah' => 'wilayah5@contoh.com',
                'telepon_wilayah' => '081234567894',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_wilayah' => 'Wilayah 6',
                'alamat_wilayah' => 'Jl. Wilayah 6 No.6',
                'kota_wilayah' => 'Kota F',
                'email_wilayah' => 'wilayah6@contoh.com',
                'telepon_wilayah' => '081234567895',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
