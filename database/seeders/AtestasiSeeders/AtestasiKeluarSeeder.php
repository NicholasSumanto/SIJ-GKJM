<?php

namespace Database\Seeders\atestasiSeeders;

use Illuminate\Database\Seeder;
use App\Models\AtestasiKeluar;

class AtestasiKeluarSeeder extends Seeder
{
    public function run()
    {
        AtestasiKeluar::factory()->count(50)->create();
    }
}
