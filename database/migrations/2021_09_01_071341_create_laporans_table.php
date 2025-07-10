<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('laporan_num')->nullable();
            $table->string('tahun')->nullable();
            $table->string('tahun_akhir')->nullable();
            $table->string('suku_tahun')->nullable();
            $table->string('suku_tahun_akhir')->nullable();
            $table->string('shuttle_type')->nullable();
            $table->string('spesis')->nullable();
            $table->json('data_laporan')->nullable();
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
        Schema::dropIfExists('laporans');
    }
}
