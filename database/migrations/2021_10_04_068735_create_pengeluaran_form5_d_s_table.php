<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranForm5DSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_form5_d_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form5ds_id');
            $table->unsignedBigInteger('jenis_kayu_id');
            $table->string('catatan')->nullable();
            $table->float('pengeluaran_kayu')->nullable();
            $table->string('total_jumlah_pengeluaran')->nullable();
            $table->timestamps();

            $table->foreign('form5ds_id')->references('id')->on('form5_d_s');
            $table->foreign('jenis_kayu_id')->references('id')->on('jenis_kayus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengeluaran_form5_d_s');
    }
}
