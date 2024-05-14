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
        Schema::create('katalog_rotis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('resep_roti_id');
            $table->integer('stok')->nullable();
            $table->integer('laku')->nullable();
            $table->longText('deskripsi');

            $table->foreign('resep_roti_id')->references('id')->on('resep_rotis')->onUpdate('cascade');
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
        Schema::dropIfExists('katalog_rotis');
    }
};
