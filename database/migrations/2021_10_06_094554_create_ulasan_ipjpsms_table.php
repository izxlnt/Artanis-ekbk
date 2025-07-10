<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlasanIpjpsmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulasan_ipjpsms', function (Blueprint $table) {
            $table->id();
            $table->string('ulasan')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('formbs_id')->nullable();
            $table->unsignedBigInteger('formas_id')->nullable();
            $table->unsignedBigInteger('formcs_id')->nullable();
            $table->unsignedBigInteger('formds_id')->nullable();
            $table->unsignedBigInteger('form4ds_id')->nullable();
            $table->unsignedBigInteger('form4es_id')->nullable();
            $table->unsignedBigInteger('form5ds_id')->nullable();
            $table->unsignedBigInteger('form5es_id')->nullable();
            // $table->unsignedBigInteger('formes_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('formbs_id')->references('id')->on('formbs');
            $table->foreign('formas_id')->references('id')->on('form_a_s');
            $table->foreign('formcs_id')->references('id')->on('form_c_s');
            $table->foreign('formds_id')->references('id')->on('form_d_s');
            $table->foreign('form4ds_id')->references('id')->on('form4_d_s');
            $table->foreign('form4es_id')->references('id')->on('form4_e_s');
            $table->foreign('form5ds_id')->references('id')->on('form5_d_s');
            $table->foreign('form5es_id')->references('id')->on('form5_e_s');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ulasan_ipjpsms');
    }
}
