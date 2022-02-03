<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganZiswafsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangan_ziswafs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('item');
            $table->unsignedBigInteger('debit')->nullable();
            $table->unsignedBigInteger('kredit')->nullable();
            $table->unsignedBigInteger('saldo')->nullable();
            $table->unsignedBigInteger('debit_infaq')->nullable();
            $table->unsignedBigInteger('debit_pinjaman')->nullable();
            $table->unsignedBigInteger('kredit_infaq')->nullable();
            $table->unsignedBigInteger('kredit_pinjaman')->nullable();
            $table->unsignedBigInteger('saldo_infaq')->nullable();
            $table->unsignedBigInteger('piutang')->nullable();
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
        Schema::dropIfExists('keuangan_ziswafs');
    }
}
