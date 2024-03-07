<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResepRoti extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nama_resep_roti',
        'gambar_roti'
    ];

    // protected function data(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }

    public function getPropertiesAttribute()
    {
        return explode(',', $this->nama_bahan_baku);
    }

    public function bahanBaku()
    {
        return $this->belongsToMany(StokBahanBaku::class, 'resep_bahan_bakus', 'resep_roti_id', 'stok_bahan_baku_id');
    }

    public function resepBahanBakus()
    {
        return $this->hasMany(ResepBahanBaku::class);
    }

    public function ProduksiRoti()
    {
        return $this->hasMany(ProduksiRoti::class,'resep_id','id');
    }

    public function katalogRoti()
    {
        return $this->hasOne(KatalogRoti::class,'resep_roti_id','id');
    }
}
