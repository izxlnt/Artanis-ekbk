<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_d_s', function (Blueprint $table) {
            $table->id();

            $table->string('shuttle_type')->nullable();
            $table->string('status')->nullable();
            $table->string('tahun')->nullable();
            $table->string('bulan')->nullable();
            $table->date('tarikh_buka_borang')->nullable();
            $table->date('tarikh_tutup_borang')->nullable();
            $table->string('nama_kilang')->nullable();
            $table->string('no_ssm')->nullable();
            $table->string('no_lesen')->nullable();
            $table->string('total_export')->nullable();
            $table->string('total_export_cleaning')->nullable();
            $table->string('jumlah_pasaran_tempatan')->nullable();
            $table->string('jumlah_pasaran_tempatan_cleaning')->nullable();
            $table->string('status_catatan')->nullable();
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
        Schema::dropIfExists('form_d_s');
    }
}
