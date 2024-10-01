<?php

namespace Database\Seeders\JemaatSeeders;

use Illuminate\Database\Seeder;
use App\Models\Majelis;

class MajelisSeeder extends Seeder
{
    public function run()
    {
        Majelis::factory()->count(10)->create();
    }
}

