<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('maintenance_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(false);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->text('message')->nullable();
            $table->text('catatan')->nullable();
            $table->string('dikemaskini_oleh')->nullable();
            $table->timestamps();
        });

        // Insert a default record
        DB::table('maintenance_settings')->insert([
            'is_active'        => false,
            'start_date'       => null,
            'end_date'         => null,
            'message'          => null,
            'catatan'          => null,
            'dikemaskini_oleh' => null,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_settings');
    }
}
