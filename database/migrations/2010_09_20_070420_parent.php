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
        Schema::create('pendeta', function (Blueprint $table) {
            $table->id('id_pendeta');
            $table->string("nama_pendeta");
            $table->string("jenjang", 50);
            $table->string("sekolah");
            $table->integer("tahun_lulus")->nullable();;
            $table->string("keterangan")->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string("ijazah")->nullable();
            $table->bigInteger('id_status')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('id_status')->references('id_status')->on('status')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('pendeta_didik', function (Blueprint $table) {
            $table->id('id_didik');
            $table->bigInteger('id_pendeta')->unsigned()->nullable();
            $table->string("nama_pendeta_didik");
            $table->string("jenjang",50);
            $table->string("sekolah");
            $table->integer("tahun_lulus");
            $table->string("keterangan");
            $table->string("ijazah");
            $table->timestamps();
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade')->onDelete('set null');

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
        Schema::dropIfExists('pendeta');
        Schema::dropIfExists('pendeta_didik');
        Schema::dropIfExists('wilayah');
        Schema::dropIfExists('provinsi');
        Schema::dropIfExists('jabatan_majelis');
        Schema::dropIfExists('jabatan_nonmajelis');
    }
};
