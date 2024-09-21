<?php

namespace Database\Seeders;

use App\Models\users_model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;

class Users_seeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the Pengguna table.
     *
     * @return void
     */
    public function run()
    {
        users_model::factory()->count(10)->create();
        DB::table('Users')->insert([
            [
                'username' => 'admin',
                'nama_user'=> 'Super Admin',
                'password' => Hash::make('admin123'),
                'id_role' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
