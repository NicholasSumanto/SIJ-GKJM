<?php

namespace Database\Seeders\JemaatSeeders;

use Illuminate\Database\Seeder;
use App\Models\JemaatTitipan;

class JemaatTitipanSeeder extends Seeder
{
    public function run()
    {
        JemaatTitipan::factory()->count(20)->create();
    }
}

