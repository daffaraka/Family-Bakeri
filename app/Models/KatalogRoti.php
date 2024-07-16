<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KatalogRoti extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =
    [
        'resep_roti_id',
        'stok',
        'laku',
        'deskripsi',
        'jumlah_bahan_baku'
    ];

    public function resepRoti()
    {
        return $this->belongsTo(ResepRoti::class,'resep_roti_id','id');
    }

    public function katalog()
    {
        return $this->hasOne(Order::class);
    }
}