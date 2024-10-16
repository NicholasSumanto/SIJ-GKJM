<?php

namespace Database\Seeders\JemaatSeeders;

use Illuminate\Database\Seeder;
use App\Models\Jemaat;

class JemaatSeeder extends Seeder
{
    public function run()
    {
        Jemaat::factory()->count(20)->create();
    }
}
