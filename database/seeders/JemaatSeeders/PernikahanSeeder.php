<?php

namespace Database\Seeders\JemaatSeeders;

use Illuminate\Database\Seeder;
use App\Models\Pernikahan;

class PernikahanSeeder extends Seeder
{
    public function run()
    {
        Pernikahan::factory()->count(20)->create();
    }
}

