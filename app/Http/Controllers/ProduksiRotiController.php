<?php

namespace App\Http\Controllers;

use App\Models\ResepRoti;
use App\Models\ProduksiRoti;
use Illuminate\Http\Request;
use App\Models\StokBahanBaku;
use Carbon\Carbon;
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
        return view('dashboard.roti.produksi-index', compact('produksi'));
    }

    public function create()
    {

        $resep = ResepRoti::all();
        return view('dashboard.roti.produksi-create', compact('resep'));
    }

    public function store(Request $request)
    {
        $resep = ResepRoti::with('bahanBaku')->find($request->resep_id);

        $produksiRoti = new ProduksiRoti([
            'nama_roti' => $resep->nama_resep_roti,
            'rencana_produksi' => $request->rencana_produksi,
            'diajukan_oleh' => Auth::check() ? Auth::user()->name : 'Test',
            'resep_id' => $request->resep_id,
            'dibuat_tanggal' => Carbon::now()->toDate(),
        ]);
        // // Simpan objek ke database
        $produksiRoti->save();
        alert()->success('Sukses', 'Roti baru telah ditambahkan');

        return redirect()->route('produksi.index');
        // }
    }


    public function show($id)
    {
        $roti = ProduksiRoti::with(['RealisasiProduksi', 'ResepRoti.resepBahanBakus.bahanBaku'])->find($id);

        // dd($roti->ResepRoti);
        return view('dashboard.roti.produksi-show', compact('roti'));
    }

    public function edit()
    {
        $roti = ProduksiRoti::all();
        return view('dashboard.roti.produksi-edit', compact('roti'));
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
        $produksiRoti = ProduksiRoti::with('ResepRoti')->find($id);

        $produksiRoti->delete();
        alert::success('Berhasil', 'Data produksi roti telah dihapus');

        return redirect()->route('produksi.index');
    }


    public function createRealisasi($id)
    {
        $roti = ProduksiRoti::with('ResepRoti')->find($id);


        return view('dashboard.roti.produksi-create-realisasi', compact('roti'));
    }


    public function getDataResep($id)
    {
        $resep = ResepRoti::with('resepBahanBakus.bahanBaku')->find($id);

        return response()->json($resep);
    }
}
