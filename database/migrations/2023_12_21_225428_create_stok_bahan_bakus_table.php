<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_bahan_bakus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_bahan_baku');
            $table->bigInteger('jumlah');
            $table->bigInteger('jumlah_minimal');
            $table->string('satuan');
            $table->string('terakhir_diedit_by');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_bahan_bakus');
    }
};
