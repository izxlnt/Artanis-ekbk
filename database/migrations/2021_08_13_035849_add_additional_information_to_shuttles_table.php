<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalInformationToShuttlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shuttles', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('no_lesen')->nullable();
            $table->string('status_hak_milik')->nullable();
            $table->string('status_warganegara')->nullable();
            $table->string('sijil_ssm')->nullable();
            $table->string('lesen_kilang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shuttles', function (Blueprint $table) {
            Schema::dropIfExists('email');
            Schema::dropIfExists('website');
            Schema::dropIfExists('no_lesen');
            Schema::dropIfExists('status_hak_milik');
            Schema::dropIfExists('status_warganegara');

        });
    }
}
