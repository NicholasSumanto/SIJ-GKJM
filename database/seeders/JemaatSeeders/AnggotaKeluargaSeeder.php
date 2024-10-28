<?php

namespace Database\Seeders\JemaatSeeders;

use Illuminate\Database\Seeder;
use App\Models\AnggotaKeluarga;

class AnggotaKeluargaSeeder extends Seeder
{
    public function run()
    {
        AnggotaKeluarga::factory()->count(20)->create();
    }
}
