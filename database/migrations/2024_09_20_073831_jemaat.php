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
            $table->enum('status_pernikahan', ['Menikah', 'Cerai']);
            $table->string('nomor', 50);
            $table->string('nama_gereja');
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
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('jemaat', function (Blueprint $table) {
            $table->increments('id_jemaat');
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->bigInteger('id_status')->unsigned()->nullable();
            $table->string('stamboek', 10)->nullable();
            $table->string('nama_jemaat', 200);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kelamin', 10)->nullable();
            $table->string('alamat_jemaat')->nullable();
            $table->bigInteger('id_kelurahan')->unsigned()->nullable();
            $table->bigInteger('id_kecamatan')->unsigned()->nullable();
            $table->bigInteger('id_kabupaten')->unsigned()->nullable();
            $table->bigInteger('id_provinsi')->unsigned()->nullable();
            $table->string('kodepos')->nullable();
            $table->string('telepon', 50)->nullable();
            $table->string('hp', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('no_kk', 20)->nullable();
            $table->string('photo', 255)->nullable();
            $table->date('tanggal_baptis')->nullable();
            $table->string('golongan_darah', 3)->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('ilmu')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('instansi', 250)->nullable();
            $table->string('penghasilan', 50)->nullable();
            $table->string('gereja_baptis', 250)->nullable();
            $table->string('alat_transportasi', 100)->nullable();
            $table->timestamps();
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_status')->references('id_status')->on('status')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kelurahan')->references('id_kelurahan')->on('kelurahan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kabupaten')->references('id_kabupaten')->on('kabupaten')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_provinsi')->references('id_provinsi')->on('provinsi')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('jemaat_baru', function (Blueprint $table) {
            $table->increments('id_jemaat');
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->bigInteger('id_status')->unsigned()->nullable();
            $table->string('stamboek', 10)->nullable();
            $table->string('nama_jemaat', 200);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kelamin', 10)->nullable();
            $table->string('alamat_jemaat')->nullable();
            $table->bigInteger('id_kelurahan')->unsigned()->nullable();
            $table->bigInteger('id_kecamatan')->unsigned()->nullable();
            $table->bigInteger('id_kabupaten')->unsigned()->nullable();
            $table->bigInteger('id_provinsi')->unsigned()->nullable();
            $table->string('kodepos')->nullable();
            $table->string('telepon', 50)->nullable();
            $table->string('hp', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('no_kk', 20)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('validasi')->nullable();
            $table->date('tanggal_baptis')->nullable();
            $table->string('golongan_darah', 3);
            $table->bigInteger('id_pendidikan')->unsigned()->nullable();
            $table->bigInteger('id_ilmu')->unsigned()->nullable();
            $table->bigInteger('id_pekerjaan')->unsigned()->nullable();
            $table->string('instansi', 250)->nullable();
            $table->string('penghasilan', 50)->nullable();
            $table->string('gereja_baptis', 250)->nullable();
            $table->string('alat_transportasi', 100)->nullable();
            $table->timestamps();
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_status')->references('id_status')->on('status')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kelurahan')->references('id_kelurahan')->on('kelurahan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_kabupaten')->references('id_kabupaten')->on('kabupaten')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_provinsi')->references('id_provinsi')->on('provinsi')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pendidikan')->references('id_pendidikan')->on('pendidikan')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('jemaat_titipan', function (Blueprint $table) {
            $table->id('id_titipan');
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->string('nama_jemaat')->nullable();
            $table->date('tanggal_titipan');
            $table->date('tanggal_selesai');
            $table->string('nama_gereja_asal');
            $table->string('nama_gereja_tujuan');
            $table->string('kelamin');
            $table->text('alamat_jemaat');
            $table->string('titipan');
            $table->string('surat');
            $table->enum('status_titipan', ['Selesai', 'Belum Selesai']);
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('keluarga', function (Blueprint $table) {
            $table->id('id_keluarga');
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->string('keterangan_hubungan');
            $table->bigInteger('id_wilayah')->unsigned()->nullable();
            $table->foreign('id_wilayah')->references('id_wilayah')->on('wilayah')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id('id_anggota_keluarga');
            $table->bigInteger('id_keluarga')->unsigned()->nullable();
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->string('keterangan_hubungan');
            $table->string('nama_anggota')->nullable();
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_keluarga')->references('id_keluarga')->on('keluarga')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('kematian', function (Blueprint $table) {
            $table->id('id_kematian');
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->string('nama_gereja');
            $table->bigInteger('id_pendeta')->unsigned()->nullable();
            $table->date('tanggal_meninggal');
            $table->date('tanggal_pemakaman');
            $table->string('tempat_pemakaman');
            $table->string('keterangan');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_pendeta')->references('id_pendeta')->on('pendeta')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('majelis', function (Blueprint $table) {
            $table->id('id_majelis');
            $table->string('nama_majelis');
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->bigInteger('id_jabatan')->unsigned()->nullable();
            $table->bigInteger('id_status')->unsigned()->nullable();
            $table->string('no_sk');
            $table->string('berkas');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan_majelis')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_status')->references('id_status')->on('status')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('nonmajelis', function (Blueprint $table) {
            $table->id('id_nonmajelis');
            $table->string('nama_majelis_non',);
            $table->unsignedInteger('id_jemaat')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->bigInteger('id_jabatan_non')->unsigned()->nullable();
            $table->bigInteger('id_status')->unsigned()->nullable();
            $table->string('no_sk');
            $table->string('berkas');
            $table->foreign('id_jemaat')->references('id_jemaat')->on('jemaat')->onUpdate('cascade')->onDelete('set null');
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
