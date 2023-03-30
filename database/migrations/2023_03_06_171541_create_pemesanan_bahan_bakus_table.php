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
        Schema::create('pemesanan_bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bahan_baku');
            $table->bigInteger('jumlah_pesanan');
            $table->string('status_pesanan');
            $table->bigInteger('harga_satuan');
            $table->bigInteger('total_harga');
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
        Schema::dropIfExists('bahan_bakus');
    }
};
