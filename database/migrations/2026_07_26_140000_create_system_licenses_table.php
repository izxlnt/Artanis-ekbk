<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSystemLicensesTable extends Migration
{
    public function up()
    {
        Schema::create('system_licenses', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_locked')->default(false);
            $table->string('nonce', 64)->nullable();
            $table->text('locked_message')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->string('locked_reason')->nullable();
            $table->timestamp('unlocked_at')->nullable();
            $table->timestamps();
        });

        DB::table('system_licenses')->insert([
            'is_locked'  => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('system_licenses');
    }
}
