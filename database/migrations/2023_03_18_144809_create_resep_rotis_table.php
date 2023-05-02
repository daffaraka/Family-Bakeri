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
        Schema::create('resep_rotis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_resep_roti');
            $table->integer('harga');
            $table->integer('stok_sekarang')->default(0);
            $table->integer('laku');
            $table->integer('ppn');
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
        Schema::dropIfExists('resep_rotis');
    }
};
