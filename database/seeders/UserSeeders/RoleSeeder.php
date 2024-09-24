<?php

namespace Database\Seeders\UserSeeders;

use App\Models\UserModels\RolePengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Seed the Role table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_pengguna')->insert([
            ['nama_role' => 'Super Admin','created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),],
            ['nama_role' => 'Admin Wilayah 1','created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),],
            ['nama_role' => 'Admin Wilayah 3','created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),],
            ['nama_role' => 'Admin Wilayah 4','created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),],
            ['nama_role' => 'Admin Wilayah 5','created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),],
            ['nama_role' => 'Admin Wilayah 6','created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),],


        ]);
    }
}

