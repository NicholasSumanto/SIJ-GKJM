<?php

namespace Database\Seeders\GeoSeeders;

use Illuminate\Database\Seeder;
use App\Models\Kabupaten;

class KabupatenSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Kabupaten::factory()->count(100)->create();
    }
}

