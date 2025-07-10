<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLaporanToGunaTenagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guna_tenagas', function (Blueprint $table) {
            $table->string('pekerja_wargabumi_lelaki_laporan')->nullable()->default(0);
            $table->string('pekerja_wargabumi_perempuan_laporan')->nullable()->default(0);
            $table->string('pekerja_bukan_wargabumi_lelaki_laporan')->nullable()->default(0);
            $table->string('pekerja_bukan_wargabumi_perempuan_laporan')->nullable()->default(0);
            $table->string('pekerja_asing_lelaki_laporan')->nullable()->default(0);
            $table->string('pekerja_asing_perempuan_laporan')->nullable()->default(0);
            $table->string('jumlah_lelaki_laporan')->nullable()->default(0);
            $table->string('jumlah_perempuan_laporan')->nullable()->default(0);
            $table->string('jumlah_pekerja_laporan')->nullable()->default(0);
            $table->string('gaji_lelaki_laporan')->nullable()->default(0);
            $table->string('gaji_perempuan_laporan')->nullable()->default(0);
            $table->string('gaji_lelaki_perempuan_laporan')->nullable()->default(0);
            $table->string('total_gaji_lelaki_laporan')->nullable()->default(0);
            $table->string('total_gaji_perempuan_laporan')->nullable()->default(0);
            $table->string('total_gaji_laporan')->nullable()->default(0);






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
