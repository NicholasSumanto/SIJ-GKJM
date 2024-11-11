<?php

namespace Database\Seeders\JemaatSeeders;

use Illuminate\Database\Seeder;
use App\Models\JemaatBaru;

class JemaatBaruSeeder extends Seeder
{
    public function run()
    {
        JemaatBaru::factory()->count(20)->create();
    }
}
