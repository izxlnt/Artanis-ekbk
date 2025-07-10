<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('tahun')->nullable();
            // $table->string('shuttle_type')->nullable();
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
        Schema::dropIfExists('form_a_s');
    }
}
