<?php

namespace Database\Seeders\atestasiSeeders;

use Illuminate\Database\Seeder;
use App\Models\AtestasiMasuk;

class AtestasiMasukSeeder extends Seeder
{
    public function run()
    {
        AtestasiMasuk::factory()->count(50)->create();
    }
}
