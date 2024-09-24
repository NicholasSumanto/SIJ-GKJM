<?php

namespace Database\Seeders\JemaatSeeders;

use Illuminate\Database\Seeder;
use App\Models\Kematian;

class KematianSeeder extends Seeder
{
    public function run()
    {
        Kematian::factory()->count(50)->create();
    }
}
