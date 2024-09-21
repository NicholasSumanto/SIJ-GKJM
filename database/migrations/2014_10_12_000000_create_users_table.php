<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_pengguna', function (Blueprint $table) {
            $table->id('id_role');
            $table->enum('nama_role', ['Super Admin','Admin Wilayah 1','Admin Wilayah 2','Admin Wilayah 3','Admin Wilayah 4','Admin Wilayah 5','Admin Wilayah 6']);
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->string('username',100)->primary();
            $table->string('nama_user');
            $table->string('password');
            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')->references('id_role')->on('role_pengguna')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RolePengguna');
        Schema::dropIfExists('user_login');
    }
}
