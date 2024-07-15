<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PemesananOnline;
use Illuminate\Http\Request;

class PemesananOnlineController extends Controller
{

    public function index()
    {
        $data = Order::with(['katalog.resepRoti','customer'])->latest()->get();

        return view('dashboard.pemesanan-online.order-index',compact('data'));
    }


    public function show($id)
    {
        $order = Order::with(['katalog.resepRoti','customer'])->find($id);

        return view('dashboard.pemesanan-online.order-detail',compact('order'));
    }

}
