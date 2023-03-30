<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBahanBaku extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'nama_bahan_baku',
        'jumlah',
        'satuan',
        'terakhir_diedit_by'
    ];
}
