<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLaporanToForm4ESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form4_e_s', function (Blueprint $table) {
            $table->string('total_export_laporan')->nullable()->default(0);
            $table->string('jumlah_pasaran_tempatan_laporan')->nullable()->default(0);
            $table->string('jumlah_venier_eksport_laporan')->nullable()->default(0);
            $table->string('jumlah_venier_tempatan_laporan')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form4_e_s', function (Blueprint $table) {
            //
        });
    }
}
