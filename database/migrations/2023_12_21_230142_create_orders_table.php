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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_pemesan');
            $table->longText('deskripsi_pesanan');
            $table->longText('order_id');
            $table->string('kontak_pemesan');
            $table->date('tanggal_diambil');
            $table->integer('qty');
            $table->enum('payment_status', ['1', '2', '3', '4'])->comment('1=menunggu pembayaran, 2=sudah dibayar, 3=kadaluarsa, 4=batal');
            $table->string('snap_token')->nullable();
            $table->bigInteger('total');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('katalog_id');

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('katalog_id')->references('id')->on('katalog_rotis')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('orders');
    }
};
