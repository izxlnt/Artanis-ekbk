<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAktifToKategoriGunaTenagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kategori_guna_tenagas', function (Blueprint $table) {
            $table->boolean('aktif')->default(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kategori_guna_tenagas', function (Blueprint $table) {
            $table->dropColumn('aktif');

        });
    }
}
