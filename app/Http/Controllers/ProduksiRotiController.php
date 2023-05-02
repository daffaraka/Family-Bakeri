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
    function __construct()
    {
        $this->middleware('permission:produksi_roti-list|produksi_roti-create|produksi_roti-edit|produksi_roti-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:produksi_roti-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:produksi_roti-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:produksi_roti-delete', ['only' => ['destroy']]);
    }

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
        $resep = ResepRoti::with('bahanBaku')->find($request->nama);
        $roti = ProduksiRoti::firstWhere('nama_roti', $resep->nama_resep_roti);


        // Jika sudah ada data roti
        // if ($roti) {
        //     foreach ($resep->resepBahanBakus as $bahanBaku) {
        //         // Hitung jumlah bahan baku yang dibutuhkan


        //         $bahanBakuNeeded = $bahanBaku->jumlah_bahan_baku * $request->stok_masuk;

        //         // Ambil stok bahan baku dari database
        //         $stokBahanBaku = StokBahanBaku::findOrFail($bahanBaku->stok_bahan_baku_id);

        //         // Periksa apakah stok cukup
        //         if ($stokBahanBaku->jumlah == 0 || $stokBahanBaku->jumlah < $bahanBakuNeeded) {
        //             // Jika stok tidak cukup, kembalikan response error

        //             alert()->error('Kesalahan', 'Bahan Baku Tidak Cukup');
        //             return redirect()->back();
        //         }

        //         // Kurangi stok bahan baku
        //         $stokBahanBaku->jumlah -= $bahanBakuNeeded;
        //         $stokBahanBaku->save();
        //     }

        //     $roti->stok_masuk += $request->stok_masuk;
        //     $roti->stok_sekarang += $request->stok_masuk;
        //     $roti->save();

        //     alert()->success('Sukses', 'Roti telah diperbarui');
        //     return redirect()->route('produksi.index');


        // } else {

            foreach ($resep->resepBahanBakus as $bahanBaku) {
                // Hitung jumlah bahan baku yang dibutuhkan


                $bahanBakuNeeded = $bahanBaku->jumlah_bahan_baku * $request->stok_masuk;


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
                'stok_masuk' => $request->stok_masuk,
                'diproduksi_oleh' => Auth::check() ? Auth::user()->name : 'Test',
                'resep_id' => $request->nama,
            ]);

            $resep->stok_sekarang += $request->stok_masuk;
            $resep->save();

            // Simpan objek ke database
            $produksiRoti->save();
            alert()->success('Sukses', 'Roti baru telah ditambahkan');


            return redirect()->route('produksi.index');
        // }
    }

    public function edit()
    {
        $roti = ProduksiRoti::all();
        return view('roti.produksi-edit', compact('roti'));
    }

    public function update(Request $request)
    {

        $roti = ProduksiRoti::firstWhere('nama_roti', $request->nama_roti);

        $roti->stok_masuk += $request->stok_masuk;
        $roti->stok_sekarang += $request->stok_masuk;
        $roti->save();


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
