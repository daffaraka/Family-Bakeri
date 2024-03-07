<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ProduksiRoti;
use Illuminate\Http\Request;
use App\Models\RealisasiProduksi;
use App\Models\StokBahanBaku;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class RealisasiProduksiController extends Controller
{

    public function index()
    {
        $realisasi = RealisasiProduksi::all();

        return view('dashboard.realisasi-produksi.realisasi-index', compact('realisasi'));
    }


    public function create()
    {
        $produksi = ProduksiRoti::whereDate('created_at', Carbon::today()->toDateString())->get();
        return view('dashboard.realisasi-produksi.realisasi-create', compact('produksi'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_realisasi' => 'numeric|required',
            'waktu_dimulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $rencanaProduksi = ProduksiRoti::with('RealisasiProduksi')->find($request->produksi_id);
        $totalTerealisasi = $rencanaProduksi->RealisasiProduksi->sum('jumlah_realisasi');
        $roti = ProduksiRoti::with(['ResepRoti.resepBahanBakus', 'ResepRoti.katalogRoti', 'RealisasiProduksi'])->find($request->produksi_id);
        $resepBB = $roti->ResepRoti;


        // dd($resep->RealisasiProduksi->sum('jumlah_realisasi'));

        // Cek jika Katalog roti sudah ada atau belum
        if($roti->ResepRoti->katalogRoti === null) {
            alert()->warning('Katalog roti tidak ditemukan', 'Katalog roti masih kosong atau belum dibuat. Mohon tambahkan katalog roti terlebih dahulu');
            return redirect()->back();
        } else {
            // Jika Sudah ada
            $roti->ResepRoti->katalogRoti->stok += $request->jumlah_realisasi;
            $roti->ResepRoti->katalogRoti->save();
        }

        if ($request->has('produksi_id')) {

            if ($request->jumlah_realisasi > $rencanaProduksi->rencana_produksi) {

                alert()->warning('Peringatan', 'Data realisasi melebihi jumlah rencana yang ditentukan. Mohon perbaiki data');
                return redirect()->back();
            } else {
                foreach ($resepBB->resepBahanBakus as $bahanBaku) {
                    $bahanBakuNeeded = $bahanBaku->jumlah_bahan_baku * $request->jumlah_realisasi;
                    $stokBahanBaku = StokBahanBaku::findOrFail($bahanBaku->stok_bahan_baku_id);
                    if ($stokBahanBaku->jumlah == 0 || $stokBahanBaku->jumlah < $bahanBakuNeeded) {
                        alert()->error('Kesalahan', 'Bahan Baku Tidak Cukup');
                        return redirect()->back();
                    }
                    $stokBahanBaku->jumlah -= $bahanBakuNeeded;
                    $stokBahanBaku->save();
                }
                RealisasiProduksi::create([
                    'diproduksi_oleh' => $request->diproduksi_oleh ?? Auth::user()->name,
                    'jumlah_realisasi' => $request->jumlah_realisasi,
                    'produksi_id' => $request->produksi_id,
                    'waktu_dimulai' => $request->waktu_dimulai,
                    'waktu_selesai' => $request->waktu_selesai,
                ]);




                alert()->success('Berhasil', 'Data realisasi Berhasil Ditambahkan');
                return redirect()->route('produksi.detail', ['id' => $request->produksi_id]);
            }
        }
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $realisasi = RealisasiProduksi::find($id);
        return view('dashboard.realisasi-produksi.realisasi-edit', compact('realisasi'));
    }


    public function update(Request $request, $id)
    {
        $realisasi = RealisasiProduksi::with('ProduksiRoti')->find($id);
        $realisasi->update($request->all());

        Alert::success('Berhasil', 'Data ' . $realisasi->ProduksiRoti->nama_roti . ' realisasi produksi roti telah diperbarui');
        return redirect()->route('realisasi.index');
    }

    public function destroy($id)
    {
        $realisasi = RealisasiProduksi::with('ProduksiRoti')->find($id);
        Alert::success('Berhasil', 'Data ' . $realisasi->ProduksiRoti->nama_roti . ' telah dihapus');
        $realisasi->delete();
        return redirect()->route('realisasi.index');
    }
}
