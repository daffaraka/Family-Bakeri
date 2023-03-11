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


        for($i = 1; $i <= 30; $i++) {
            StokBahanBaku::create([
                'nama_bahan_baku' => $faker->word(),
                'jumlah' => $faker->numberBetween(1,1000),
            ]);
        }
    }
}
