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
        Schema::create('kabupaten', function (Blueprint $table) {
            $table->id('id_kabupaten')->primary();
            $table->unsignedBigInteger("id_provinsi");
            $table->string("kabupaten",100);
            $table->foreign('id_provinsi')->references('id_provinsi')->on('provinsi')
            ->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->id('id_kecamatan')->primary();
            $table->unsignedBigInteger("id_kabupaten");
            $table->string("kecamatan");
            $table->foreign('id_kabupaten')->references('id_kabupaten')->on('kabupaten')
            ->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->id('id_kelurahan')->primary();
            $table->unsignedBigInteger("id_kecamatan");
            $table->string("kelurahan");
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')
            ->onUpdate('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kabupaten');
        Schema::dropIfExists('kecamatan');
        Schema::dropIfExists('kelurahan');
    }
};
