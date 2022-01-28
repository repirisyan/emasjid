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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('id_jabatan',[1,2,3,4])->nullable(); // 1 = distribusi, 2 = produksi, 3 = bendahara, 4 = ketua
            $table->string('name');
            $table->string('range_gaji')->nullable();
            $table->string('password');
            $table->string('TempatLahir');
            $table->date('TanggalLahir');
            $table->string('alamat');
            $table->string('kontak')->unique();
            $table->string('email')->unique()->nullable();
            $table->char('JenisKelamin');
            $table->string('role');
            $table->string('picture');
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
