<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProduksiRoti extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable =
    [
        'nama_roti',
        'rencana_produksi',
        'diajukan_oleh',
        'resep_id',
        'kode_produksi',
        'dibuat_tanggal'
    ];



    protected static function boot()
    {
        parent::boot();

        // Otomatis buat Produk-1 , Produk-2, Produk-3 dst
        static::creating(function ($roti) {
            $lastRoti = static::where('nama_roti', $roti->nama_roti)
                ->orderBy('kode_produksi', 'desc')
                ->first();

            if ($lastRoti) {
                $lastCode = explode('-', $lastRoti->kode_produksi);
                $number = intval(end($lastCode));
                $roti->kode_produksi = $roti->nama_roti . '-' . ($number + 1);
            } else {
                $roti->kode_produksi = $roti->nama_roti . '-1';
            }
        });
    }

    public function ResepRoti()
    {
        return $this->belongsTo(ResepRoti::class, 'resep_id');
    }

    public function RealisasiProduksi()
    {
        return $this->hasMany(RealisasiProduksi::class, 'produksi_id');
    }
}
