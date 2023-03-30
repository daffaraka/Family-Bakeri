<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokBahanBaku;
use Illuminate\Support\Facades\Auth;

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

        StokBahanBaku::create(
            [
                'nama_bahan_baku' => $request->nama_bahan_baku,
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'terakhir_diedit_by' => Auth::user()->name ??'Test',
            ]
            );


        return redirect()->route('stok.index');
    }
}
