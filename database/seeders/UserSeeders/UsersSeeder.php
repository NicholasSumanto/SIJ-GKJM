<?php

namespace Database\Seeders\UserSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Seed the User table.
     *
     * @return void
     */
    public function run()
    {

        $roles = DB::table('role_pengguna')->pluck('id_role')->take(6)->toArray();

        foreach (range(1, 8) as $index) {
            $id_role = $roles[array_rand($roles) % count($roles)];


            User::factory()->create([
                'id_role' => $id_role,
            ]);
        }

        User::create([
            'username' => 'admin',
            'nama_user' => 'Admin User',
            'password' => bcrypt('admin'),
            'id_role' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
