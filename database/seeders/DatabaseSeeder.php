<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeders\{RoleSeeder, UsersSeeder};
use Database\Seeders\ParentSeeders\{StatusSeeder, BidangIlmuSeeder, PendidikanSeeder, PekerjaanSeeder, PendetaSeeder, PendetaDidikSeeder, WilayahSeeder, JabatanMajelisSeeder, JabatanNonMajelisSeeder};
use Database\Seeders\BaptisSeeders\{BaptisAnakSeeder,BaptisDewasaSeeder,BaptisSidiSeeder};
use Database\Seeders\JemaatSeeders\{PernikahanSeeder,jemaatSeeder,JemaatBaruSeeder,JemaatTitipanSeeder,KeluargaSeeder,AnggotaKeluargaSeeder,KematianSeeder,MajelisSeeder,NonMajelisSeeder};
use Database\Seeders\AtestasiSeeders\{AtestasiKeluarSeeder,AtestasiKeluarDtlSeeder,AtestasiMasukSeeder};
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UsersSeeder::class,
            StatusSeeder::class,
            // BidangIlmuSeeder::class,
            // PendidikanSeeder::class,
            // PekerjaanSeeder::class,
            PendetaSeeder::class,
            // PendetaDidikSeeder::class,
            WilayahSeeder::class,
            JabatanMajelisSeeder::class,
            JabatanNonMajelisSeeder::class,
            BaptisAnakSeeder::class,
            BaptisDewasaSeeder::class,
            BaptisSidiSeeder::class,
            PernikahanSeeder::class,
            JemaatSeeder::class,
            JemaatBaruSeeder::class,
            JemaatTitipanSeeder::class,
            KeluargaSeeder::class,
            AnggotaKeluargaSeeder::class,
            KematianSeeder::class,
            MajelisSeeder::class,
            NonMajelisSeeder::class,
            AtestasiKeluarSeeder::class,
            AtestasiKeluarDtlSeeder::class,
            AtestasiMasukSeeder::class,
        ]);
    }
}
