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
        'nama_bahan_baku',
        'jumlah_bahan_baku'
    ];

    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

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
}
