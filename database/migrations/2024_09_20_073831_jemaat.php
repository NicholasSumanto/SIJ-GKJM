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
            $table->id('id_nikah')->primary();
            $table->string('nomor', 50);
            $table->bigInteger('id_gereja')->unsigned()->nullable();
            $table->date('tanggal_nikah');
            $table->bigInteger('id_pendeta')->unsigned()->nullable();
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
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('jemaat', function (Blueprint $table) {
            $table->id('id_jemaat')->primary();
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->bigInteger('id_status')->unsigned()->nullable();
            $table->string('stamboek', 10);
            $table->string('nama_jemaat', 200);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('agama', 10);
            $table->string('kelamin', 10);
            $table->string('alamat_jemaat');
            $table->bigInteger('id_kelurahan')->unsigned()->nullable();
            $table->bigInteger('id_kecamatan')->unsigned()->nullable();
            $table->bigInteger('id_kabupaten')->unsigned()->nullable();
            $table->bigInteger('id_provinsi')->unsigned()->nullable();
            $table->string('kodepos');
            $table->string('telepon', 50);
            $table->string('hp', 30);
            $table->string('email', 100);
            $table->string('nik', 16);
            $table->string('no_kk', 20);
            $table->string('photo', 255);
            $table->bigInteger('id_nikah')->unsigned()->nullable();
            $table->bigInteger('id_sidi')->unsigned()->nullable();
            $table->bigInteger('id_ba')->unsigned()->nullable();
            $table->bigInteger('id_bd')->unsigned()->nullable();
            $table->date('tanggal_baptis');
            $table->string('golongan_darah', 3);
            $table->bigInteger('id_pendidikan')->unsigned()->nullable();
            $table->bigInteger('id_ilmu')->unsigned()->nullable();
            $table->bigInteger('id_pekerjaan')->unsigned()->nullable();
            $table->string('instansi', 250);
            $table->string('penghasilan', 50);
            $table->string('gereja_baptis', 250);
            $table->string('alat_transportasi', 100);
            $table->timestamps();
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_nikah')->references('id_nikah')->on('pernikahan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_sidi')->references('id_sidi')->on('baptis_sidi')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_ba')->references('id_ba')->on('baptis_anak')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_bd')->references('id_bd')->on('baptis_dewasa')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_status')->references('id_status')->on('status')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kelurahan')->references('id_kelurahan')->on('kelurahan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kabupaten')->references('id_kabupaten')->on('kabupaten')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_provinsi')->references('id_provinsi')->on('provinsi')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pendidikan')->references('id_pendidikan')->on('pendidikan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_ilmu')->references('id_ilmu')->on('bidangilmu')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pekerjaan')->references('id_pekerjaan')->on('pekerjaan')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('jemaat_titipan', function (Blueprint $table) {
            $table->id('id_titipan')->primary();
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->string('nama_jemaat', 200);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('agama',['Kristen','Katholik','Islam','Buddha','Hindu','Khonghucu','Lainnya']);
            $table->string('kelamin', 10);
            $table->text('alamat_jemaat');
            $table->text('alamat_domisili');
            $table->bigInteger('id_kelurahan')->unsigned()->nullable();
            $table->bigInteger('id_kecamatan')->unsigned()->nullable();
            $table->bigInteger('id_kabupaten')->unsigned()->nullable();
            $table->bigInteger('id_provinsi')->unsigned()->nullable();
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
            $table->bigInteger('id_pendidikan')->unsigned()->nullable();
            $table->bigInteger('id_ilmu')->unsigned()->nullable();
            $table->bigInteger('id_pekerjaan')->unsigned()->nullable();
            $table->string('instansi', 250);
            $table->string('penghasilan', 50);
            $table->string('gereja_ibadah', 250);
            $table->string('alat_transportasi', 100);
            $table->string('nomorsurat', 100);
            $table->string('surat', 100);
            $table->timestamps();
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kelurahan')->references('id_kelurahan')->on('kelurahan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kabupaten')->references('id_kabupaten')->on('kabupaten')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_provinsi')->references('id_provinsi')->on('provinsi')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pendidikan')->references('id_pendidikan')->on('pendidikan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_ilmu')->references('id_ilmu')->on('bidangilmu')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pekerjaan')->references('id_pekerjaan')->on('pekerjaan')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('keluarga', function (Blueprint $table) {
            $table->id('id_keluarga')->primary();
            $table->bigInteger('id_jemaat')->unsigned()->nullable();
            $table->bigInteger('id_gereja')->unsigned()->nullable();
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('keluarga_detil', function (Blueprint $table) {
            $table->id('id_keluarga_detil')->primary();
            $table->bigInteger('id_jemaat')->unsigned()->nullable();
            $table->bigInteger('id_keluarga')->unsigned()->nullable();
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_keluarga')->references('id_keluarga')->on('keluarga')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('kematian', function (Blueprint $table) {
            $table->id('id_kematian')->primary();
            $table->bigInteger('id_jemaat')->unsigned()->nullable();
            $table->bigInteger('id_gereja')->unsigned()->nullable();
            $table->bigInteger('id_pendeta')->unsigned()->nullable();
            $table->date('tanggal_meninggal');
            $table->date('tanggal_pemakaman');
            $table->string('tempat_pemakaman');
            $table->string('keterangan');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('majelis', function (Blueprint $table) {
            $table->id('id_majelis')->primary();
            $table->string('nama_majelis');
            $table->bigInteger('id_jemaat')->unsigned()->nullable();
            $table->bigInteger('id_gereja')->unsigned()->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->bigInteger('id_jabatan')->unsigned()->nullable();
            $table->bigInteger('id_status')->unsigned()->nullable();
            $table->string('no_sk');
            $table->string('berkas');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan_majelis')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_status')->references('id_status')->on('status')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('nonmajelis', function (Blueprint $table) {
            $table->id('id_nonmajelis')->primary();
            $table->string('nama_majelis_non',);
            $table->bigInteger('id_jemaat')->unsigned()->nullable();
            $table->bigInteger('id_gereja')->unsigned()->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->bigInteger('id_jabatan_non')->unsigned()->nullable();
            $table->bigInteger('id_status')->unsigned()->nullable();
            $table->string('no_sk');
            $table->string('berkas');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_gereja')->references('id_gereja')->on('gereja')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_jabatan_non')->references('id_jabatan_non')->on('jabatan_nonmajelis')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_status')->references('id_status')->on('status')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('nonmajelis');
        Schema::dropIfExists('majelis');
    }
};
