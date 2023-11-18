<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ProduksiRoti;
use Illuminate\Http\Request;
use App\Models\RealisasiProduksi;
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

        // dd(Carbon::now()->toDateString());

        $produksi = ProduksiRoti::whereDate('created_at', Carbon::today()->toDateString())->get();


        // dd($produksi);

        return view('dashboard.realisasi-produksi.realisasi-create', compact('produksi'));
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'jumlah_realisasi' => 'numeric|required',
            'waktu_dimulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->has('produksi_id')) {

            RealisasiProduksi::create([
                'jumlah_realisasi' => $request->jumlah_realisasi,
                'diproduksi_oleh' => $request->diproduksi_oleh,
                'produksi_id' => $request->produksi_id,
                'waktu_dimulai' => $request->waktu_dimulai,
                'waktu_selesai' => $request->waktu_selesai,
            ]);


            return redirect()->route('produksi.detail',['id'=>$request->produksi_id]);
        }
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $realisasi = RealisasiProduksi::find($id);
        return view('dashboard.realisasi-produksi.realisasi-edit',compact('realisasi'));
    }


    public function update(Request $request, $id)
    {
        $realisasi = RealisasiProduksi::with('ProduksiRoti')->find($id);
        $realisasi->update($request->all());

        Alert::success('Berhasil', 'Data '.$realisasi->ProduksiRoti->nama_roti.' realisasi produksi roti telah diperbarui');
        return redirect()->route('realisasi.index');

    }

    public function destroy($id)
    {
        $realisasi = RealisasiProduksi::with('ProduksiRoti')->find($id);
        Alert::success('Berhasil', 'Data '.$realisasi->ProduksiRoti->nama_roti.' telah dihapus');
        $realisasi->delete();
        return redirect()->route('realisasi.index');

    }
}
