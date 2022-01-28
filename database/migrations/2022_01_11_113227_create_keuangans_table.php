<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('detail_saldo_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('kategori', [1, 2]); //1=Pemasukan, 2=Pengeluaran,
            $table->date('tanggal');
            $table->string('keterangan');
            $table->unsignedBigInteger('nilai');
            $table->enum('status', [1, 2, 3]); //1=Diterima, 2=Menunggu, 3=Ditolak
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
        Schema::dropIfExists('keuangans');
    }
}
