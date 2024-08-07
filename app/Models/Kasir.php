<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kasir extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =
    [
        'nama_roti',
        'harga',
        'stok_masuk',
        'stok_sekarang',
        'laku',
        'sisa_total',
        'roti_off',
        'rizky',
        'palem',
        'moro_jaya',
        'total_rizky',
        'total_palem',
        'total_moro_jaya',
        // mulai totalan akhir
        'total_penjualan_ini',
        'total_penjualan_keseluruhan',
        'total_pesanan',
        'total_ppn',
        'total_toko',
        'total_after_ppn',
        'tanggal_diproduksi'
    ];
}
