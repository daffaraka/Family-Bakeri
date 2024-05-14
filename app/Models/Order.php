<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable =
    [
        'nama_pemesan',
        'deskripsi_pesanan',
        'kontak_pemesan',
        'tanggal_diambil',
        'qty',
        'payment_status',
        'snap_token',
        'katalog_id',
        'order_id',
        'user_id'

    ];


    protected static function boot()
    {
        parent::boot();

        // Otomatis buat Produk-1 , Produk-2, Produk-3 dst
        static::creating(function ($order) {
            $lastOrder = static::latest()->first();

            if ($lastOrder) {
                $lastCode = explode('-', $lastOrder->order_id);
                $number = intval($lastCode[1]);
                $order->order_id = 'ORDER-' . ($number + 1) . ' - ' . date('Y-m-d - H:i:s');
            } else {
                $order->order_id = 'ORDER-1' . ' - ' . date('Y-m-d - H:i:s');
            }

        });
    }


    public function katalog()
    {
        return $this->belongsTo(KatalogRoti::class,'katalog_id');
    }

    public function customer()

    {
        return $this->belongsTo(User::class,'user_id');
    }

}
