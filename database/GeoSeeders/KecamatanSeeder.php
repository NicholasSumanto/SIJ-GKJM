<?php

namespace Database\Seeders\GeoSeeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Kecamatan::factory()->count(200)->create();
    }
}
