<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemesananOnline extends Model
{
    use HasFactory,SoftDeletes;


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
