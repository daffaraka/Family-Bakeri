<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananOnline extends Model
{
    use HasFactory;


    protected $filable =
    [
        'nama_pemesan',
        'deskripsi_pesanan',
        'status',
        'total',
        'qty',
        'perkiraan_siap',
        'snap_token'
    ];
}
