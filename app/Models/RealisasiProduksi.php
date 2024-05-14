<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RealisasiProduksi extends Model
{
    use HasFactory,SoftDeletes;


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
