<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanKumaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_kumais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shuttle_id');
            $table->string('bulan');
            $table->string('tahun');
            $table->string('status');
            $table->string('status_catatan');
            $table->string('jumlah_jualan_pasaran_tempatan');
            $table->string('jumlah_jualan_eksport');
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
        Schema::dropIfExists('penjualan_kumais');
    }
}
