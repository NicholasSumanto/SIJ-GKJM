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
            $table->unsignedBiginteger('id_wilayah')->nullable();
            $table->string('nama_gereja');
            $table->string('no_surat');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('atestasi_keluar_dtl', function (Blueprint $table) {
            $table->id('id_keluar_dtl');
            $table->unsignedBigInteger('id_keluar');
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->string('keterangan');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_keluar')->references('id_keluar')->on('atestasi_keluar')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('atestasi_masuk', function (Blueprint $table) {
            $table->id('id_masuk');
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->string('nama_gereja');
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->string('no_surat');
            $table->date('tanggal_masuk');
            $table->string('surat');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
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
