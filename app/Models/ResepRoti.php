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
        'nama_roti',
        'nama_bahan_baku',
        'jumlah_bahan_baku'
    ];

    protected $casts = [
        'nama_bahan_baku' => 'array', // Will convarted to (Array)
        'jumlah_bahan_baku' => 'array'
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
}
