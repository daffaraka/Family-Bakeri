<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemesananBahanBaku extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =
    [
        'nama_bahan_baku',
        'harga_satuan',
        'dp',
        'deadline_dp',
        'sisa_pembayaran',
        'jumlah_pesanan',
        'status_pesanan',
        'total_harga',
        'stok_bahan_id'

    ];
}
