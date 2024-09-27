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
        Schema::create('baptis_anak', function (Blueprint $table) {
            $table->id('id_ba')->primary();
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->bigInteger('id_pendeta')->unsigned()->nullable();
            $table->string('nomor');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('ayah');
            $table->string('ibu');
            $table->date('tanggal_baptis');
            $table->string('ketua_majelis');
            $table->string('sekretaris_majelis');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('baptis_dewasa', function (Blueprint $table) {
            $table->id('id_bd')->primary();
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->bigInteger('id_pendeta')->unsigned()->nullable();
            $table->string('nomor');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('ayah');
            $table->string('ibu');
            $table->date('tanggal_baptis');
            $table->string('ketua_majelis');
            $table->string('sekretaris_majelis');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('baptis_sidi', function (Blueprint $table) {
            $table->id('id_sidi')->primary();
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->bigInteger('id_pendeta')->unsigned()->nullable();
            $table->string('nomor');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('ayah');
            $table->string('ibu');
            $table->date('tanggal_baptis');
            $table->string('ketua_majelis');
            $table->string('sekretaris_majelis');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptis_anak');
        Schema::dropIfExists('baptis_dewasa');
        Schema::dropIfExists('baptis_sidi');
    }
};
