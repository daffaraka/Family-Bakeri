<?php

namespace Database\Seeders;

use App\Models\PemesananBahanBaku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PemesananBahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $harga_satuan = $faker->numberBetween(100,100000);
        $jumlah_pesanan = $faker->numberBetween(1,1000);
        for($i = 1; $i <= 30; $i++) {
            PemesananBahanBaku::create([
                'nama_bahan_baku' => $faker->word(),
                'jumlah_pesanan' => $jumlah_pesanan,
                'harga_satuan' => $harga_satuan,
                'status_pesanan' => $faker->randomElement(['Sedang Diantar', 'Diterima','Dibayar']),
                'total_harga' => $harga_satuan * $jumlah_pesanan
            ]);
        }
    }
}
