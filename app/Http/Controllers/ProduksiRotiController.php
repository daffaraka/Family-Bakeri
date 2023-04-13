<?php

namespace App\Http\Controllers;

use App\Models\ProduksiRoti;
use App\Models\ResepRoti;
use Illuminate\Http\Request;
use App\Models\StokBahanBaku;
use Illuminate\Support\Facades\Auth;

class ProduksiRotiController extends Controller
{
    public function index()
    {
        $produksi = ProduksiRoti::all();
        return view('roti.produksi-index', compact('produksi'));
    }

    public function create()
    {

        $resep = ResepRoti::all();
        return view('roti.produksi-create', compact('resep'));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $resep = ResepRoti::with('bahanBaku')->find($request->nama);


        foreach ($resep->resepBahanBakus as $bahanBaku) {
            // Hitung jumlah bahan baku yang dibutuhkan


            $bahanBakuNeeded = $bahanBaku->jumlah_bahan_baku * $request->jumlah_produksi;





            // Ambil stok bahan baku dari database
            $stokBahanBaku = StokBahanBaku::findOrFail($bahanBaku->stok_bahan_baku_id);

            // Periksa apakah stok cukup
            if ($stokBahanBaku->jumlah == 0 || $stokBahanBaku->jumlah < $bahanBakuNeeded) {
                // Jika stok tidak cukup, kembalikan response error
                return response()->json(['message' => 'Stok bahan baku tidak cukup'], 400);
            }


            // Kurangi stok bahan baku
            $stokBahanBaku->jumlah -= $bahanBakuNeeded;
            $stokBahanBaku->save();
        }

        // Buat objek ProduksiRoti baru
        $produksiRoti = new ProduksiRoti([
            'nama_roti' => $resep->nama_resep_roti,
            'jumlah_produksi' => $request->jumlah_produksi,
            'diproduksi_oleh' => Auth::check() ? Auth::user()->name : 'Test',
            'resep_id' => $request->nama,
        ]);

        // Simpan objek ke database
        $produksiRoti->save();


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

    public function delete($id)
    {
        $produksiRoti = ProduksiRoti::find($id);
        $produksiRoti->delete();

        return redirect()->route('produksi.index');
    }
}
