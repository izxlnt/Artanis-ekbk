<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGunaTenagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guna_tenagas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('pekerja_wargabumi_lelaki')->nullable();
            $table->integer('pekerja_wargabumi_lelaki_cleaning')->nullable();

            $table->integer('pekerja_wargabumi_perempuan')->nullable();
            $table->integer('pekerja_wargabumi_perempuan_cleaning')->nullable();

            $table->integer('pekerja_bukan_wargabumi_lelaki')->nullable();
            $table->integer('pekerja_bukan_wargabumi_lelaki_cleaning')->nullable();

            $table->integer('pekerja_bukan_wargabumi_perempuan')->nullable();
            $table->integer('pekerja_bukan_wargabumi_perempuan_cleaning')->nullable();

            $table->integer('pekerja_asing_lelaki')->nullable();
            $table->integer('pekerja_asing_lelaki_cleaning')->nullable();

            $table->integer('pekerja_asing_perempuan')->nullable();
            $table->integer('pekerja_asing_perempuan_cleaning')->nullable();

            //correction datatype sebelum production

            // $table->decimal('gaji_lelaki',30,2)->nullable();
            // $table->decimal('gaji_lelaki_cleaning',30,2)->nullable();

            // $table->decimal('gaji_perempuan',30,2)->nullable();
            // $table->decimal('total_gaji_perempuan_cleaning',30,2)->nullable();

            // $table->decimal('total_gaji',30,2)->nullable();
            // $table->decimal('total_gaji_cleaning',30,2)->nullable();

            // $table->decimal('total_gaji_perempuan',30,2)->nullable();
            // $table->decimal('total_gaji_perempuan_cleaning',30,2)->nullable();



            $table->double('gaji_lelaki')->nullable();
            $table->double('gaji_lelaki_cleaning')->nullable();

            $table->double('gaji_perempuan')->nullable();
            $table->double('gaji_perempuan_cleaning')->nullable();

            $table->double('total_gaji_lelaki')->nullable();
            $table->double('total_gaji_lelaki_cleaning')->nullable();

            $table->double('total_gaji_perempuan')->nullable();
            $table->double('total_gaji_perempuan_cleaning')->nullable();

            $table->double('total_gaji')->nullable();
            $table->double('total_gaji_cleaning')->nullable();

            $table->integer('jumlah_lelaki')->nullable();
            $table->integer('jumlah_lelaki_cleaning')->nullable();

            $table->integer('jumlah_perempuan')->nullable();
            $table->integer('jumlah_perempuan_cleaning')->nullable();

            $table->integer('jumlah_pekerja')->nullable();
            $table->integer('jumlah_pekerja_cleaning')->nullable();

            $table->decimal('gaji_lelaki_perempuan',30,2)->nullable();
            $table->decimal('gaji_lelaki_perempuan_cleaning',30,2)->nullable();

            $table->integer('total_bumi_lelaki')->nullable();
            $table->integer('total_bumi_lelaki_cleaning')->nullable();

            $table->integer('total_bumi_perempuan')->nullable();
            $table->integer('total_bumi_perempuan_cleaning')->nullable();

            $table->integer('total_bukanbumi_lelaki')->nullable();
            $table->integer('total_bukanbumi_lelaki_cleaning')->nullable();

            $table->integer('total_bukanbumi_perempuan')->nullable();
            $table->integer('total_bukanbumi_perempuan_cleaning')->nullable();

            $table->integer('total_asing_lelaki')->nullable();
            $table->integer('total_asing_lelaki_cleaning')->nullable();

            $table->integer('total_asing_perempuan')->nullable();
            $table->integer('total_asing_perempuan_cleaning')->nullable();

            $table->integer('total_pekerja_lelaki')->nullable();
            $table->integer('total_pekerja_lelaki_cleaning')->nullable();

            $table->integer('total_pekerja_perempuan')->nullable();
            $table->integer('total_pekerja_perempuan_cleaning')->nullable();

            $table->integer('total_pekerja')->nullable();
            $table->integer('total_pekerja_cleaning')->nullable();

            $table->decimal('jumlah_gaji_lelaki',30,2)->nullable();
            $table->decimal('jumlah_gaji_lelaki_cleaning',30,2)->nullable();

            $table->decimal('jumlah_gaji_perempuan',30,2)->nullable();
            $table->decimal('jumlah_gaji_perempuan_cleaning',30,2)->nullable();

            $table->decimal('jumlah_lelaki_perempuan',30,2)->nullable();
            $table->decimal('jumlah_lelaki_perempuan_cleaning',30,2)->nullable();

            $table->decimal('jumlah_total_lelaki',30,2)->nullable();
            $table->decimal('jumlah_total_lelaki_cleaning',30,2)->nullable();

            $table->decimal('jumlah_total_perempuan',30,2)->nullable();
            $table->decimal('jumlah_total_perempuan_cleaning',30,2)->nullable();

            $table->decimal('jumlah_total_gaji',30,2)->nullable();
            $table->decimal('jumlah_total_gaji_cleaning',30,2)->nullable();

            $table->unsignedBigInteger('shuttle_id');
            $table->unsignedBigInteger('kategori_guna_tenaga_id');
            $table->string('bulan');
            $table->string('tahun');
            $table->unsignedBigInteger('formbs_id');


            $table->foreign('shuttle_id')->references('id')->on('shuttles');
            $table->foreign('formbs_id')->references('id')->on('formbs');
            $table->foreign('kategori_guna_tenaga_id')->references('id')->on('kategori_guna_tenagas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guna_tenagas');
    }
}
