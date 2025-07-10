<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShuttlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shuttles', function (Blueprint $table) {
            $table->id();
            $table->string('shuttle_type')->nullable();
            $table->string('tahun')->nullable();
            $table->string('nama_kilang')->nullable();
            $table->text('alamat_kilang_1')->nullable();
            $table->text('alamat_kilang_2')->nullable();
            $table->string('alamat_kilang_poskod')->nullable();
            $table->string('alamat_kilang_daerah')->nullable();



            $table->text('alamat_surat_menyurat_1')->nullable();
            $table->text('alamat_surat_menyurat_2')->nullable();
            $table->string('alamat_surat_menyurat_poskod')->nullable();
            $table->string('alamat_surat_menyurat_daerah')->nullable();


            $table->string('longtitude_x')->nullable();
            $table->string('langtitude_y')->nullable();
            $table->string('no_telefon')->nullable();
            $table->string('no_faks')->nullable();
            $table->string('no_ssm')->unique()->nullable();
            $table->date('tarikh_tubuh')->nullable();
            $table->date('tarikh_operasi')->nullable();

            $table->string('taraf_syarikat_catatan')->nullable();



            $table->string('nilai_harta')->nullable();
            $table->string('catatan_1')->nullable();
            $table->string('catatan_2')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->string('negeri_id')->constrained('negeris');





        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shuttles');
    }
}
