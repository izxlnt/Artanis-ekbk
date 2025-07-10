<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKemasukanBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kemasukan_bahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spesis_id');
            $table->float('baki_stok', 10, 2)->nullable();
            $table->float('kayu_masuk', 10, 2)->nullable();
            $table->float('proses_masuk', 10, 2)->nullable();
            $table->float('proses_keluar', 10, 2)->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->unsignedBigInteger('kemasukan_id')->nullable();
            $table->unsignedBigInteger('shuttle_id');
            $table->unsignedBigInteger('formcs_id');

            $table->float('jumlah_baki_stok', 10, 2)->nullable();
            $table->float('jumlah_kayu_masuk', 10, 2)->nullable();
            $table->float('total_stok_kayu_balak', 10, 2)->nullable();
            $table->float('total_kayu_masuk_jentera', 10, 2)->nullable();
            $table->float('total_kayu_keluar_jentera', 10, 2)->nullable();
            $table->float('total_kayu_dibawa_bulan_hadapan', 10, 2)->nullable();

            $table->float('jumlah_stok_kayu_balak', 10, 2)->nullable();
            $table->float('baki_stok_kehadapan', 10, 2)->nullable();
            $table->float('jumlah_besar_baki_stok_bulan_lepas', 10, 2)->nullable();
            $table->float('jumlah_besar_kemasukan_kayu_ke_kilang', 10, 2)->nullable();
            $table->float('jumlah_besar_stok_kayu_balak', 10, 2)->nullable();
            $table->float('jumlah_besar_kayu_ke_dalam_jentera', 10, 2)->nullable();
            $table->float('jumlah_besar_pengeluaran_kayu_daripada_jentera', 10, 2)->nullable();
            $table->float('jumlah_besar_baki_stok_bulan_depan', 10, 2)->nullable();

            $table->timestamps();



            $table->foreign('spesis_id')->references('id')->on('spesis');
            $table->foreign('kemasukan_id')->references('id')->on('kemasukans');
            $table->foreign('shuttle_id')->references('id')->on('shuttles');
            $table->foreign('formcs_id')->references('id')->on('form_c_s');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kemasukan_bahans');
    }
}
