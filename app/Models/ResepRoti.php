<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepRoti extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nama_roti',
        'nama_bahan_baku',
        'jumlah_bahan_baku'
    ];
}
