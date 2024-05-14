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
        Schema::create('realisasi_produksis', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_realisasi');
            $table->string('diproduksi_oleh');
            $table->unsignedBigInteger('produksi_id');
            $table->time('waktu_dimulai');
            $table->time('waktu_selesai');
            $table->foreign('produksi_id')->references('id')->on('produksi_rotis')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('realisasi_produksis');
    }
};
