<?php

namespace App\Http\Controllers;

use App\Models\ResepRoti;
use App\Models\ProduksiRoti;
use Illuminate\Http\Request;
use App\Models\StokBahanBaku;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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

                alert()->error('Kesalahan', 'Bahan Baku Tidak Cukup');
                return redirect()->back();
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

    public function edit($id)
    {
        $roti = ProduksiRoti::find($id);
        return view('roti.produksi-edit', compact('roti'));
    }

    public function update(Request $request, $id)
    {
        $roti = ProduksiRoti::find($id);

        $roti->update($request->all());


        alert()->success('Sukses', 'Data ' . $roti->nama_roti . ' telah diperbarui');

        return redirect()->route('produksi.index');
    }

    public function delete($id)
    {
        $produksiRoti = ProduksiRoti::find($id);
        $produksiRoti->delete();

        return redirect()->route('produksi.index');
    }
}
