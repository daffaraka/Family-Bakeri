<?php

namespace Database\Seeders;

use App\Models\StokBahanBaku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class StokBahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Butter',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Gandum',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Tepung',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Safron',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Telur',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Butir',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Gula',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Gula Merah',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Tepung Tapioka',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Gula Pasir',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Baking Soda',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Gula',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Coklat',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Aromatic',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Garam',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Susu Kering',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);

            StokBahanBaku::create([
                'nama_bahan_baku' => 'Tepung Terigu',
                'jumlah' => $faker->numberBetween(1,10000),
                'satuan' => 'Kg',
                'terakhir_diedit_by' => $faker->randomElement(['Admin','User','Family Bakery'])
            ]);
    }
}
