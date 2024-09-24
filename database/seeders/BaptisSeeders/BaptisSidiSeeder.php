<?php

namespace Database\Seeders\BaptisSeeders;

use Illuminate\Database\Seeder;
use App\Models\BaptisSidi;

class BaptisSidiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BaptisSidi::factory()->count(50)->create();
    }
}
