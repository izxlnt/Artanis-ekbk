<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKemasukansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kemasukans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shuttle_id');
            $table->string('tahun');
            $table->string('bulan');
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
        Schema::dropIfExists('kemasukans');
    }
}
