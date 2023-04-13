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
            $table->bigInteger('jumlah');
            $table->integer('laku');
            $table->bigInteger('sisa_total');
            $table->bigInteger('rizky');
            $table->bigInteger('palem');
            $table->bigInteger('moro_jaya');
            $table->bigInteger('total_rizky')->nullable();
            $table->bigInteger('total_palem')->nullable();
            $table->bigInteger('total_moro_jaya')->nullable();
            $table->bigInteger('total_penjualan')->nullable();
            $table->bigInteger('total_pesanan')->nullable();
            $table->bigInteger('ppn')->nullable();
            $table->bigInteger('total_toko')->nullable();
            $table->bigInteger('total_after_ppn')->nullable();
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
