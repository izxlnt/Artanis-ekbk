<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shuttle_id');
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('total_export');
            $table->string('status');
            $table->string('status_catatan');
            $table->timestamps();

            $table->foreign('shuttle_id')->references('id')->on('shuttles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
