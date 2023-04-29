<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanStokBahanBaku extends Model
{
    use HasFactory;


    public function StokBahanBaku()
    {
        return $this->belongsTo(StokBahanBaku::class,'stok_id');
    }
}
