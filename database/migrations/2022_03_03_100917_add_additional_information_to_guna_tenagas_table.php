<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalInformationToGunaTenagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guna_tenagas', function (Blueprint $table) {
            $table->string('total_bumi_lelaki_laporan')->nullable()->default(0);
            $table->string('total_bumi_perempuan_laporan')->nullable()->default(0);
            $table->string('total_bukanbumi_lelaki_laporan')->nullable()->default(0);
            $table->string('total_bukanbumi_perempuan_laporan')->nullable()->default(0);
            $table->string('total_asing_lelaki_laporan')->nullable()->default(0);
            $table->string('total_asing_perempuan_laporan')->nullable()->default(0);
            $table->string('total_pekerja_lelaki_laporan')->nullable()->default(0);
            $table->string('total_pekerja_perempuan_laporan')->nullable()->default(0);
            $table->string('total_pekerja_laporan')->nullable()->default(0);
            $table->string('jumlah_gaji_lelaki_laporan')->nullable()->default(0);
            $table->string('jumlah_gaji_perempuan_laporan')->nullable()->default(0);
            $table->string('jumlah_lelaki_perempuan_laporan')->nullable()->default(0);
            $table->string('jumlah_total_lelaki_laporan')->nullable()->default(0);
            $table->string('jumlah_total_perempuan_laporan')->nullable()->default(0);
            $table->string('jumlah_total_gaji_laporan')->nullable()->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guna_tenagas', function (Blueprint $table) {
            //
        });
    }
}
