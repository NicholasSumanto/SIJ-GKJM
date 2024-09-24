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
        Schema::create('pernikahan', function (Blueprint $table) {
            $table->id('id_nikah');
            $table->string('nomor', 50);
            $table->unsignedBigInteger('id_gereja');
            $table->date('tanggal_nikah');
            $table->unsignedBigInteger('id_pendeta');
            $table->string('pengantin_pria', 100);
            $table->string('pengantin_wanita', 100);
            $table->string('ayah_pria', 100);
            $table->string('ibu_pria', 100);
            $table->string('ayah_wanita', 100);
            $table->string('ibu_wanita', 100);
            $table->string('saksi1', 100);
            $table->string('saksi2', 100);
            $table->enum('warga',['Warga Jemaat','Bukan Warga']);
            $table->string('tempat', 250);
            $table->string('ketua_majelis', 100);
            $table->string('sekretaris_majelis', 100);
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('jemaat', function (Blueprint $table) {
            $table->id('id_jemaat');
            $table->unsignedBigInteger('id_wilayah');
            $table->unsignedBigInteger('id_status');
            $table->string('stamboek', 10);
            $table->string('nama_jemaat', 200);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('agama', 10);
            $table->string('kelamin', 10);
            $table->string('alamat_jemaat');
            $table->unsignedBigInteger('id_kelurahan');
            $table->unsignedBigInteger('id_kecamatan');
            $table->unsignedBigInteger('id_kabupaten');
            $table->unsignedBigInteger('id_provinsi');
            $table->string('kodepos');
            $table->string('telepon', 50);
            $table->string('hp', 30);
            $table->string('email', 100);
            $table->string('nik', 16);
            $table->string('no_kk', 20);
            $table->string('photo', 255);
            $table->unsignedBigInteger('id_nikah');
            $table->unsignedBigInteger('id_sidi');
            $table->unsignedBigInteger('id_ba');
            $table->unsignedBigInteger('id_bd');
            $table->date('tanggal_baptis');
            $table->string('golongan_darah', 3);
            $table->unsignedBigInteger('id_pendidikan');
            $table->unsignedBigInteger('id_ilmu');
            $table->unsignedBigInteger('id_pekerjaan');
            $table->string('instansi', 250);
            $table->string('penghasilan', 50);
            $table->string('gereja_baptis', 250);
            $table->string('alat_transportasi', 100);
            $table->timestamps();
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade');
            $table->foreign('id_nikah')->references('id_nikah')->on('pernikahan')->onUpdate('cascade');
            $table->foreign('id_sidi')->references('id_sidi')->on('baptis_sidi')->onUpdate('cascade');
            $table->foreign('id_ba')->references('id_ba')->on('baptis_anak')->onUpdate('cascade');
            $table->foreign('id_bd')->references('id_bd')->on('baptis_dewasa')->onUpdate('cascade');
            $table->foreign('id_status')->references('id_status')->on('status')->onUpdate('cascade');
            $table->foreign('id_kelurahan')->references('id_kelurahan')->on('kelurahan')->onUpdate('cascade');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onUpdate('cascade');
            $table->foreign('id_kabupaten')->references('id_kabupaten')->on('kabupaten')->onUpdate('cascade');
            $table->foreign('id_provinsi')->references('id_provinsi')->on('provinsi')->onUpdate('cascade');
            $table->foreign('id_pendidikan')->references('id_pendidikan')->on('pendidikan')->onUpdate('cascade');
            $table->foreign('id_ilmu')->references('id_ilmu')->on('bidangilmu')->onUpdate('cascade');
            $table->foreign('id_pekerjaan')->references('id_pekerjaan')->on('pekerjaan')->onUpdate('cascade');
        });

        Schema::create('jemaat_titipan', function (Blueprint $table) {
            $table->id('id_titipan');
            $table->unsignedBigInteger('id_wilayah');
            $table->unsignedBigInteger('id_status');
            $table->string('nama_jemaat', 200);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('agama',['Kristen','Katholik','Islam','Buddha','Hindu','Khonghucu','Lainnya']);
            $table->string('kelamin', 10);
            $table->text('alamat_jemaat');
            $table->text('alamat_domisili');
            $table->unsignedBigInteger('id_kelurahan');
            $table->unsignedBigInteger('id_kecamatan');
            $table->unsignedBigInteger('id_kabupaten');
            $table->unsignedBigInteger('id_provinsi');
            $table->string('kodepos', 100);
            $table->string('telepon', 50);
            $table->string('hp', 30);
            $table->string('email', 100);
            $table->string('nik', 16);
            $table->string('no_kk', 20);
            $table->string('nama_ortu', 100);
            $table->string('telepon_ortu', 50);
            $table->string('photo', 250);
            $table->date('tanggal_baptis');
            $table->string('golongan_darah', 3);
            $table->unsignedBigInteger('id_pendidikan');
            $table->unsignedBigInteger('id_ilmu');
            $table->unsignedBigInteger('id_pekerjaan');
            $table->string('instansi', 250);
            $table->string('penghasilan', 50);
            $table->string('gereja_ibadah', 250);
            $table->string('alat_transportasi', 100);
            $table->string('nomorsurat', 100);
            $table->string('surat', 100);
            $table->timestamps();
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade');
            $table->foreign('id_status')->references('id_status')->on('status')->onUpdate('cascade');
            $table->foreign('id_kelurahan')->references('id_kelurahan')->on('kelurahan')->onUpdate('cascade');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onUpdate('cascade');
            $table->foreign('id_kabupaten')->references('id_kabupaten')->on('kabupaten')->onUpdate('cascade');
            $table->foreign('id_provinsi')->references('id_provinsi')->on('provinsi')->onUpdate('cascade');
            $table->foreign('id_pendidikan')->references('id_pendidikan')->on('pendidikan')->onUpdate('cascade');
            $table->foreign('id_ilmu')->references('id_ilmu')->on('bidangilmu')->onUpdate('cascade');
            $table->foreign('id_pekerjaan')->references('id_pekerjaan')->on('pekerjaan')->onUpdate('cascade');
        });

        Schema::create('keluarga', function (Blueprint $table) {
            $table->id('id_keluarga');
            $table->unsignedBigInteger('id_jemaat');
            $table->unsignedBigInteger('id_gereja');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('keluarga_detil', function (Blueprint $table) {
            $table->id('id_keluarga_detil');
            $table->unsignedBiginteger('id_jemaat');
            $table->unsignedBigInteger('id_keluarga');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade');
            $table->foreign('id_keluarga')->references('id_keluarga')->on('keluarga')->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('kematian', function (Blueprint $table) {
            $table->id('id_kematian');
            $table->unsignedBiginteger('id_jemaat');
            $table->unsignedBigInteger('id_gereja');
            $table->unsignedBigInteger('id_pendeta');
            $table->date('tanggal_meninggal');
            $table->date('tanggal_pemakaman');
            $table->string('tempat_pemakaman');
            $table->string('keterangan');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade');
            $table->timestamps();
        });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pernikahan');
        Schema::dropIfExists('jemaat');
        Schema::dropIfExists('jemaat_titipan');
        Schema::dropIfExists('keluarga');
        Schema::dropIfExists('keluarga_detil');
        Schema::dropIfExists('kematian');
    }
};
