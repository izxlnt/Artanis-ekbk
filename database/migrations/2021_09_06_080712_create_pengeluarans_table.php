<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluarans', function (Blueprint $table) {


            $table->id();
            $table->unsignedBigInteger('shuttle_id');
            $table->string('tahun');
            $table->string('bulan');
            $table->decimal('rekod_veniermuka',10,2)->nullable();
            $table->decimal('rekod_venierteras',10,2)->nullable();
            $table->decimal('jumlah_pengeluaran',10,2)->nullable();
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
        Schema::dropIfExists('pengeluarans');
    }
}
