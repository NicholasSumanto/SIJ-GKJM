<?php

namespace Database\Seeders\JemaatSeeders;

use Illuminate\Database\Seeder;
use App\Models\KeluargaDetil;

class KeluargaDetilSeeder extends Seeder
{
    public function run()
    {
        KeluargaDetil::factory()->count(50)->create();
    }
}
