<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukPengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form4ds_id')->nullable();
            $table->string('produk')->nullable();
            $table->decimal('produk_ketebalan',10,2)->nullable();
            $table->decimal('produk_isipadumr',10,2)->nullable();
            $table->decimal('produk_isipaduwbp',10,2)->nullable();

            $table->decimal('jumlah_kecil_1_mr',10,2)->nullable();
            $table->decimal('jumlah_kecil_1_wbp',10,2)->nullable();
            $table->decimal('jumlah_kecil_2_mr',10,2)->nullable();
            $table->decimal('jumlah_kecil_2_wbp',10,2)->nullable();
            $table->decimal('jumlah_besar_mr',10,2)->nullable();
            $table->decimal('jumlah_besar_wbp',10,2)->nullable();


            $table->decimal('jumlah_mr',10,2)->nullable();
            $table->decimal('jumlah_wbp',10,2)->nullable();
            $table->timestamps();

            // $table->foreign('pengeluaran_id')->references('id')->on('pengeluarans');
            $table->foreign('form4ds_id')->references('id')->on('form4_d_s');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk_pengeluarans');
    }
}
