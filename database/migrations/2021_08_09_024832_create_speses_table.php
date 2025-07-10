<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spesis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tempatan');
            $table->string('nama_saintifik');
            $table->foreignId('kumpulan_kayu_id')->constrained('kumpulan_kayus');
            $table->boolean('aktif');
            $table->string('catatan')->nullable();
            $table->string('kod');
            $table->string('ringkasan')->nullable();
            $table->softDeletes();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spesis');
    }
}
