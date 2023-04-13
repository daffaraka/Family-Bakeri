<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Kasir;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KasirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        $faker = Faker::create('id_ID');
        // Loop seeder sebanyak 10 kali
        for ($i = 1; $i <= 10; $i++) {
            $harga = rand(5000, 10000) * 10;
            $jumlah = rand(100, 500);

            DB::table('kasirs')->insert([
                'nama_roti' =>$faker->randomElement(['Penjualan', 'Roti','Bahan Baku','Croissant','Cake','Donat','Burger']).' '.$i,
                'harga' => $harga,
                'stok_masuk' => rand(100, 1000),
                'jumlah' => $jumlah,
                'laku' => rand(50, 200),
                'sisa_total' => DB::raw('(stok_masuk - laku)'), // Menggunakan akhiran '0000'
                'rizky' => rand(1000, 5000) * 10, // Menggunakan akhiran '0000'
                'palem' => rand(1000, 5000) * 10, // Menggunakan akhiran '0000'
                'moro_jaya' => rand(1000, 5000) * 10, // Menggunakan akhiran '0000'
                'total_rizky' => DB::raw('rizky * laku'),
                'total_palem' => DB::raw('palem * laku'),
                'total_moro_jaya' => DB::raw('moro_jaya * laku'),
                'total_penjualan' => DB::raw('total_rizky + total_palem + total_moro_jaya + ppn'),
                'total_pesanan' => DB::raw('total_rizky + total_palem + total_moro_jaya'),
                'total_ppn' => rand(10, 50), // Menggunakan akhiran '0000'
                'total_toko' =>rand(1000, 5000) * 10, // Menggunakan akhiran '0000'
                'total_after_ppn' => DB::raw($harga . ' * ' . $jumlah),
                'tanggal_diproduksi' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
