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
        Schema::create('produksi_rotis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_roti');
            $table->integer('stok_masuk');
            $table->integer('stok_sekarang');
            $table->integer('laku');
            $table->string('diproduksi_oleh');
            $table->unsignedBigInteger('resep_id');


            $table->foreign('resep_id')->references('id')->on('resep_rotis')
                  ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('produksi_roti');
    }
};
