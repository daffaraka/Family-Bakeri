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
            $table->string('diajukan_oleh');
            $table->integer('rencana_produksi');
            $table->unsignedBigInteger('resep_id');
            $table->string('kode_produksi');


            $table->foreign('resep_id')->references('id')->on('resep_rotis')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->date('dibuat_tanggal');
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
        Schema::dropIfExists('produksi_rotis');
    }
};
