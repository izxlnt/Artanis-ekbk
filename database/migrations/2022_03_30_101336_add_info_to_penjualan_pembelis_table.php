<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoToPenjualanPembelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan_pembelis', function (Blueprint $table) {
            $table->string('jumlah_jualan_laporan')->nullable()->default(0);
            $table->string('total_jumlah_jualan_laporan')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_pembelis', function (Blueprint $table) {
            //
        });
    }
}
