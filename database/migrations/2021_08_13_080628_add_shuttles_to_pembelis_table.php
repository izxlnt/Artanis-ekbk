<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShuttlesToPembelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembelis', function (Blueprint $table) {
            $table->string('shuttle');
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
        Schema::table('pembelis', function (Blueprint $table) {
            $table->dropColumn('shuttle');
            $table->dropColumn('aktif');
        });
    }
}
