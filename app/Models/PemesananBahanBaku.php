<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananBahanBaku extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nama_bahan_baku',
        'harga_satuan',
        'jumlah_pesanan',
        'status_pesanan',
        'total_harga'

    ];
}
