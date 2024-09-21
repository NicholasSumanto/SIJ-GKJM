<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id('id_status');
            $table->string("keterangan_status",100);
            $table->timestamps();
        });
        Schema::create('gereja', function (Blueprint $table) {
            $table->id('id_gereja');
            $table->string("nama_gereja");
            $table->timestamps();
        });
        Schema::create('bidangilmu', function (Blueprint $table) {
            $table->id('id_ilmu');
            $table->string("bidangilmu",100);
            $table->timestamps();
        });
        Schema::create('pendidikan', function (Blueprint $table) {
            $table->id('id_pendidikan');
            $table->string("pendidikan");
            $table->timestamps();
        });
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->id('id_pekerjaan');
            $table->string("pekerjaan");
            $table->timestamps();
        });
        Schema::create('pendeta', function (Blueprint $table) {
            $table->id('id_pendeta');
            $table->string("nama_pendeta");
            $table->string("jenjang",50);
            $table->string("sekolah");
            $table->integer("tahun_lulus");
            $table->string("keterangan");
            $table->string("ijazah");
            $table->timestamps();
        });
        Schema::create('pendeta_didik', function (Blueprint $table) {
            $table->id('id_didik');
            $table->unsignedBigInteger('id_pendeta');
            $table->string("nama_pendeta_didik");
            $table->string("jenjang",50);
            $table->string("sekolah");
            $table->integer("tahun_lulus");
            $table->string("keterangan");
            $table->string("ijazah");
            $table->timestamps();
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')
            ->onUpdate('cascade');
        });

        Schema::create('wilayah', function (Blueprint $table) {
            $table->id('id_wilayah');
            $table->string("nama_wilayah");
            $table->string("alamat_wilayah");
            $table->string("kota_wilayah");
            $table->string("email_wilayah");
            $table->string("telepon_wilayah");
            $table->timestamps();
        });
        Schema::create('provinsi', function (Blueprint $table) {
            $table->id('id_provinsi');
            $table->string("nama_provinsi",100);
            $table->timestamps();
        });
        Schema::create('jabatan_majelis', function (Blueprint $table) {
            $table->id('id_jabatan');
            $table->string("jabatan_majelis");
            $table->integer("periode");
            $table->timestamps();
        });
        Schema::create('jabatan_nonmajelis', function (Blueprint $table) {
            $table->id('id_jabatan_non');
            $table->string("jabatan_nonmajelis",50);
            $table->integer("periode");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status');
        Schema::dropIfExists('gereja');
        Schema::dropIfExists('bidangilmu');
        Schema::dropIfExists('pendidikan');
        Schema::dropIfExists('pekerjaan');
        Schema::dropIfExists('pendeta');
        Schema::dropIfExists('pendeta_didik');
        Schema::dropIfExists('wilayah');
        Schema::dropIfExists('provinsi');
        Schema::dropIfExists('jabatan_majelis');
        Schema::dropIfExists('jabatan_nonmajelis');
    }
};
