<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiProduksi extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'jumlah_realisasi',
        'diproduksi_oleh',
        'produksi_id',
        'waktu_dimulai',
        'waktu_selesai'
    ];


    public function ProduksiRoti()
    {
        return $this->belongsTo(ProduksiRoti::class,'produksi_id');
    }
}
