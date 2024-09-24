<?php

namespace Database\Seeders\atestasiSeeders;

use Illuminate\Database\Seeder;
use App\Models\AtestasiKeluarDtl;

class AtestasiKeluarDtlSeeder extends Seeder
{
    public function run()
    {
        AtestasiKeluarDtl::factory()->count(50)->create();
    }
}
