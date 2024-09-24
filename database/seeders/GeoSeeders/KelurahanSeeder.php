<?php

namespace Database\Seeders\GeoSeeders;

use Illuminate\Database\Seeder;
use App\Models\Kelurahan;

class KelurahanSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Kelurahan::factory()->count(300)->create();
    }
}
