<?php

namespace Database\Seeders\JemaatSeeders;

use Illuminate\Database\Seeder;
use App\Models\NonMajelis;

class NonMajelisSeeder extends Seeder
{
    public function run()
    {
        NonMajelis::factory()->count(20)->create();
    }
}

