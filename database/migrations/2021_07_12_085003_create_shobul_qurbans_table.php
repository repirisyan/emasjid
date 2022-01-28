<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShobulQurbansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shobul_qurbans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_hewan_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('hewan_id')->constrained();
            $table->foreignId('qurban_id')->nullable()->constrained()->onDelete('restrict');
            $table->string('metode_pembayaran');
            $table->unsignedInteger('permintaan_daging');
            $table->unsignedInteger('permintaan_daging_confirm');
            $table->unsignedSmallInteger('status');
            $table->string('atasNama')->nullable();
            $table->string('kode_pembayaran')->unique();
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
        Schema::dropIfExists('shobul_qurbans');
    }
}
