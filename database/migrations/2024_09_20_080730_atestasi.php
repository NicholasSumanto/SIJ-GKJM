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
        Schema::create('atestasi_keluar', function (Blueprint $table) {
            $table->id('id_keluar');
            $table->unsignedBiginteger('id_jemaat');
            $table->unsignedBigInteger('id_pendeta');
            $table->unsignedBigInteger('id_gereja');
            $table->string('no_surat');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('atestasi_keluar_dtl', function (Blueprint $table) {
            $table->id('id_keluar');
            $table->unsignedBiginteger('id_jemaat');
            $table->string('keterangan');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('atestasi_masuk', function (Blueprint $table) {
            $table->id('id_masuk');
            $table->unsignedBiginteger('id_wilayah');
            $table->unsignedBigInteger('id_gereja');
            $table->string('no_surat');
            $table->date('tanggal');
            $table->string('surat');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('astestasi_keluar');
        Schema::dropIfExists('astestasi_keluar_dtl');
        Schema::dropIfExists('astestasi_masuk');
    }
};
