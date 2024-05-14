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
            $table->bigInteger('dp');
            $table->date('deadline_dp');
            $table->bigInteger('sisa_pembayaran');
            $table->string('status_pesanan');
            $table->bigInteger('harga_satuan');
            $table->bigInteger('total_harga');
            $table->unsignedBigInteger('stok_bahan_id');
            $table->timestamps();

            $table->foreign('stok_bahan_id')->references('id')->on('stok_bahan_bakus')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('pemesanan_bahan_bakus');
    }
};
