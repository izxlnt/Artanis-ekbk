<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecoveryRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recovery_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('shuttle_type');
            $table->float('min_recovery_rate')->default(0)->nullable();
            $table->float('max_recovery_rate')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recovery_rates');
    }
}
