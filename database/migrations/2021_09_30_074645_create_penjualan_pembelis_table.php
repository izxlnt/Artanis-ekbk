<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanPembelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_pembelis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formds_id')->nullable();
            $table->unsignedBigInteger('form4es_id')->nullable();
            $table->unsignedBigInteger('pembeli_id');
            $table->string('catatan')->nullable();
            $table->float('jumlah_jualan')->nullable();
            $table->float('jumlah_jualan_cleaning')->nullable();
            $table->float('total_jumlah_jualan')->nullable();
            $table->float('total_jumlah_jualan_cleaning')->nullable();
            $table->timestamps();

            $table->foreign('formds_id')->references('id')->on('form_d_s');
            $table->foreign('form4es_id')->references('id')->on('form4_e_s');
            $table->foreign('pembeli_id')->references('id')->on('pembelis');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_pembelis');
    }
}
