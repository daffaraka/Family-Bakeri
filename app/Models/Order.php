<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table =
    [
        'nama_pemesan',
        'deskripsi_pesanan',
        'kontak_pemesan',
        'tanggal_diambil',
        'qty',
        'status',
        'snap_token'
    ];
}
