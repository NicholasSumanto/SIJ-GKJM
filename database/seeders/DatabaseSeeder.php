<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeders\{RoleSeeder, UsersSeeder};
use Database\Seeders\ParentSeeders\{StatusSeeder, GerejaSeeder, BidangIlmuSeeder, PendidikanSeeder, PekerjaanSeeder, PendetaSeeder, PendetaDidikSeeder, WilayahSeeder, ProvinsiSeeder, JabatanMajelisSeeder, JabatanNonMajelisSeeder};
use Database\Seeders\GeoSeeders\{KabupatenSeeder,KecamatanSeeder,KelurahanSeeder};
use Database\Seeders\BaptisSeeders\{BaptisAnakSeeder,BaptisDewasaSeeder,BaptisSidiSeeder};
use Database\Seeders\JemaatSeeders\{PernikahanSeeder,jemaatSeeder,JemaatTitipanSeeder,KeluargaSeeder,KeluargaDetilSeeder,KematianSeeder};
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
            GerejaSeeder::class,
            BidangIlmuSeeder::class,
            PendidikanSeeder::class,
            PekerjaanSeeder::class,
            PendetaSeeder::class,
            PendetaDidikSeeder::class,
            WilayahSeeder::class,
            ProvinsiSeeder::class,
            JabatanMajelisSeeder::class,
            JabatanNonMajelisSeeder::class,
            KabupatenSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            BaptisAnakSeeder::class,
            BaptisDewasaSeeder::class,
            BaptisSidiSeeder::class,
            PernikahanSeeder::class,
            JemaatSeeder::class,
            JemaatTitipanSeeder::class,
            KeluargaSeeder::class,
            KeluargaDetilSeeder::class,
            KematianSeeder::class,
            AtestasiKeluarSeeder::class,
            AtestasiKeluarDtlSeeder::class,
            AtestasiMasukSeeder::class,
        ]);
    }
}
