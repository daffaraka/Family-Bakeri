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
        'jumlah_minimal',
        'harga_keseluruhan',
        'dp',
        'deadline_dp',
        'satuan',
        'terakhir_diedit_by'
    ];

    public function resepRotis()
    {
        return $this->belongsToMany(ResepRoti::class, 'resep_bahan_bakus', 'bahan_baku_id', 'resep_roti_id')->withPivot('jumlah_bahan_baku', 'satuan');
    }

    public function resepBahanBakus()
    {
        return $this->hasMany(ResepBahanBaku::class,'id');
    }


}
