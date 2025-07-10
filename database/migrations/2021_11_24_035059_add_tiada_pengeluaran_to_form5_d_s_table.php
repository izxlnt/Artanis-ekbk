<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTiadaPengeluaranToForm5DSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form5_d_s', function (Blueprint $table) {
            $table->string('tiada_pengeluaran')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form5_d_s', function (Blueprint $table) {
            $table->dropColumn('tiada_pengeluaran');
        });
    }
}
