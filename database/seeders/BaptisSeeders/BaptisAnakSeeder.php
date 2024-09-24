<?php

namespace Database\Seeders\BaptisSeeders;

use Illuminate\Database\Seeder;
use App\Models\BaptisAnak;

class BaptisAnakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BaptisAnak::factory()->count(50)->create();
    }
}
