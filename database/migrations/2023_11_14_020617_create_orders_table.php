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
            $table->string('kontak_pemesan');
            $table->date('tanggal_diambil');
            $table->integer('qty');
            $table->enum(['status'],['DIAJUKAN','DITERIMA','DIPROSES','CANCEL','SELESAI']);
            $table->string('snap_token');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('katalog_id');

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('catalog_id')->references('id')->on('katalog_rotis')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('orders');
    }
};
