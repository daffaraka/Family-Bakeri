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
            $table->integer('jumlah_produksi');
            $table->string('diproduksi_oleh');
            $table->foreignId('resep_id')->constrained('resep_rotis');
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
