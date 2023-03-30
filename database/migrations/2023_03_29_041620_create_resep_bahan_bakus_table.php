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
        Schema::create('resep_bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resep_roti_id');
            $table->unsignedBigInteger('stok_bahan_baku_id');
            $table->integer('jumlah_bahan_baku');
            $table->timestamps();

            $table->foreign('resep_roti_id')->references('id')->on('resep_rotis')->onDelete('cascade');
            $table->foreign('stok_bahan_baku_id')->references('id')->on('stok_bahan_bakus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resep_bahan_bakus');
    }
};
