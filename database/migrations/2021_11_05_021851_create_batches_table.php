<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('Tidak Diisi');
            $table->string('tahun')->nullable();
            $table->string('bulan')->nullable();
            $table->string('borang_a')->nullable();
            $table->string('borang_b')->nullable();
            $table->string('borang_c')->nullable();
            $table->string('borang_d')->nullable();
            $table->string('borang_e')->nullable();

            $table->unsignedBigInteger('shuttle_id')->nullable();
            $table->foreign('shuttle_id')->references('id')->on('shuttles');
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
        Schema::dropIfExists('batches');
    }
}
