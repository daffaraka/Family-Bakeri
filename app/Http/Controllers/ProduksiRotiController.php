<?php

namespace App\Http\Controllers;

use App\Models\ProduksiRoti;
use App\Models\StokBahanBaku;
use Illuminate\Http\Request;

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
        //
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
