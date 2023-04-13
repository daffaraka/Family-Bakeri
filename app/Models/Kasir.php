<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nama_roti',
        'harga',
        'stok_masuk',
        'jumlah',
        'laku',
        'sisa_total',
        'rizky',
        'palem',
        'moro_jaya',
        'total_rizky',
        'total_palem',
        'total_moro_jaya',
        'ppn',
        'total_penjualan',
        'total_pesanan',
        'pemotongan',
        'sub_total',
        'tanggal_diproduksi'
    ];
}
