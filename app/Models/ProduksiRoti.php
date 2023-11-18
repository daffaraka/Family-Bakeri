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
        'stok_masuk',
        'diproduksi_oleh',
        'resep_id'
    ];

    public function ResepRoti()
    {
        return $this->belongsTo(ResepRoti::class, 'resep_id');
    }

    public function RealisasiProduksi()
    {
        return $this->hasMany(RealisasiProduksi::class,'produksi_id');
    }
}
