<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsApprovedToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('is_approved')->default('0');
            $table->string('is_approved_ipjpsm')->default('0');
            $table->unsignedBigInteger('pengguna_kilang_id')->nullable();
            $table->unsignedBigInteger('shuttle_id')->nullable();

            $table->string('peranan')->nullable();
            $table->boolean('status')->default('1');
            $table->string('jawatan')->nullable();
            $table->string('negeri')->nullable();
            $table->string('daerah')->nullable();
            $table->string('bahagian')->nullable();
            $table->string('no_telefon')->nullable();



            $table->foreign('shuttle_id')->references('id')->on('shuttles');
            $table->foreign('pengguna_kilang_id')->references('id')->on('pengguna_kilangs');





        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_approved');

        });
    }
}
