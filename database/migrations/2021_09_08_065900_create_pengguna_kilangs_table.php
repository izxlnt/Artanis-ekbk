<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaKilangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengguna_kilangs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('jantina')->nullable();
            $table->string('warganegara')->nullable();
            $table->string('kaum')->nullable();
            $table->string('email')->nullable();
            $table->string('no_kad_pengenalan')->unique()->nullable();
            $table->string('gambar_ic_hadapan')->nullable();
            $table->string('gambar_ic_belakang')->nullable();
            $table->string('gambar_passport')->nullable();
            $table->string('jawatan')->nullable();
            $table->string('no_pekerja')->nullable();
            $table->string('gambar_kad_pekerja')->nullable();
            $table->string('shuttle_type')->nullable();
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
        Schema::dropIfExists('pengguna_kilangs');
    }
}
