<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResepBahanBaku extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable =
    [
        'resep_roti_id',
        'stok_bahan_baku_id ',
        'jumlah_bahan_baku',
        'satuan'
    ];


    public function resepRoti()
    {
        return $this->belongsTo(ResepRoti::class);
    }

    public function bahanBaku()
    {
        return $this->belongsTo(StokBahanBaku::class,'stok_bahan_baku_id','id');
    }
}
