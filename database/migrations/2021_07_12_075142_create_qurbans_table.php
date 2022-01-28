<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQurbansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qurbans', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('jumlah_disembelih');
            $table->foreignId('master_hewan_id')->constrained();
            $table->foreignId('hewan_id')->constrained()->onDelete('restrict');
            $table->unsignedInteger('jumlah_shobul');
            $table->unsignedFloat('berat_timbangan')->nullable();
            $table->unsignedInteger('antrian')->nullable();
            $table->unsignedInteger('status');
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
        Schema::dropIfExists('qurbans');
    }
}
