<?php

namespace App\Http\Controllers;

use App\Models\ProduksiRoti;
use Illuminate\Http\Request;
use App\Models\StokBahanBaku;
use Illuminate\Support\Facades\Auth;

class ProduksiRotiController extends Controller
{
    public function index()
    {
        $produksi = ProduksiRoti::all();
        return view('roti.produksi-index',compact('produksi'));
    }

    public function create()
    {

        $stok = StokBahanBaku::all();
        return view('roti.produksi-create',compact('stok'));
    }

    public function store(Request $request)
    {
        $produksi = new ProduksiRoti();

        $produksi->nama = $request->nama;
        $produksi->jumlah_produksi = $request->jumlah_produksi;
        $produksi->diproduksi_oleh = Auth::user()->name ?? 'Test';
        $produksi->save();

        return redirect()->route('produksi.index');
    }

    public function show(ProduksiRoti $produksiRoti)
    {
        //
    }


    public function edit(ProduksiRoti $produksiRoti)
    {
        //
    }

    public function update(Request $request, ProduksiRoti $produksiRoti)
    {
        //
    }

    public function destroy(ProduksiRoti $produksiRoti)
    {
        //
    }
}
