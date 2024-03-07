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
        Schema::create('kasirs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_roti');
            $table->bigInteger('harga');
            $table->bigInteger('stok_masuk');
            $table->bigInteger('stok_sekarang');
            $table->integer('laku');
            $table->bigInteger('sisa_total');
            $table->bigInteger('roti_off');
            $table->bigInteger('rizky');
            $table->bigInteger('palem');
            $table->bigInteger('moro_jaya');
            $table->bigInteger('total_rizky')->nullable()->default(0);
            $table->bigInteger('total_palem')->nullable()->default(0);
            $table->bigInteger('total_moro_jaya')->nullable()->default(0);
            $table->bigInteger('total_penjualan_ini')->nullable()->default(0);
            $table->bigInteger('total_penjualan_keseluruhan')->nullable()->default(0);
            $table->bigInteger('total_pesanan')->nullable()->default(0);
            $table->bigInteger('total_ppn')->nullable()->default(0);
            $table->bigInteger('total_toko')->nullable()->default(0);
            $table->bigInteger('total_after_ppn')->nullable()->default(0);
            $table->date('tanggal_diproduksi');
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
        Schema::dropIfExists('kasirs');
    }
};
