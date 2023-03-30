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
            $table->string('nama_roti');
            $table->string('nama_bahan_baku');
            $table->integer('jumlah_bahan_baku');
            $table->string('satuan');
            $table->foreignId('stok_roti_id')->constrained('stok_bahan_bakus');

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
