<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiRoti extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nama_roti',
        'jumlah_produksi',
        'diproduksi_oleh',
        'resep_id'
    ];

}
