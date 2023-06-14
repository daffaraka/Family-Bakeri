<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganHarian extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'toko',
        'tanggal',
        'type',
        'uraian',
        'kode_akun',
        'nominal'
    ];
}
