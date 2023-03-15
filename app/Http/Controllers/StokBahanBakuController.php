<?php

namespace App\Http\Controllers;

use App\Models\StokBahanBaku;
use Illuminate\Http\Request;

class StokBahanBakuController extends Controller
{
    public function index()
    {
        $stok = StokBahanBaku::all();
        return view('stok-bahan-baku.stok-index',compact('stok'));
    }

    public function create()
    {
        return view('stok-bahan-baku.stok-create');
    }

    public function store(Request $request)
    {

        StokBahanBaku::create($request->all());
        return redirect()->route('stok.index');
    }
}
