<?php

namespace Database\Seeders\BaptisSeeders;

use Illuminate\Database\Seeder;
use App\Models\BaptisDewasa;

class BaptisDewasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BaptisDewasa::factory()->count(50)->create();
    }
}
