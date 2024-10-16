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
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->unsignedBiginteger('id_wilayah')->nullable();
            $table->bigInteger('id_pendeta')->unsigned()->nullable();
            $table->bigInteger('id_gereja')->unsigned()->nullable();
            $table->string('no_surat');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('atestasi_keluar_dtl', function (Blueprint $table) {
            $table->id('id_keluar');
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->string('keterangan');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('atestasi_masuk', function (Blueprint $table) {
            $table->id('id_masuk');
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->bigInteger('id_gereja')->unsigned()->nullable();
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->string('no_surat');
            $table->date('tanggal');
            $table->string('surat');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
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
