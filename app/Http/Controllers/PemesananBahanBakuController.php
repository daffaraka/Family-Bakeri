<?php

namespace App\Http\Controllers;

use App\Models\PemesananBahanBaku;
use App\Models\StokBahanBaku;
use Illuminate\Http\Request;

class PemesananBahanBakuController extends Controller
{

    public function index()
    {
        $bb = PemesananBahanBaku::all();

        return view('pemesanan-bahan-baku.pemesanan-index', compact('bb'));
    }

    public function create()
    {
        $stok = StokBahanBaku::all();
        return view('pemesanan-bahan-baku.pemesanan-create',compact('stok'));
    }

    public function store(Request $request)
    {

        $bb = new PemesananBahanBaku();

        $stok = new StokBahanBaku();

        $req_bahan = $request->nama_bahan_baku;
        $cekStok = StokBahanBaku::firstWhere('nama_bahan_baku', $req_bahan);

        if ($request->status_pesanan =='Diterima' && $cekStok) {
            $cekStok->jumlah = $cekStok->jumlah + $request->jumlah_pesanan;
            $cekStok->save();
        }



        $jumlah_pesanan = $request->jumlah_pesanan;
        $harga_satuan = $request->harga_satuan;
        $bb->nama_bahan_baku = $request->nama_bahan_baku;
        $bb->jumlah_pesanan = $jumlah_pesanan;
        $bb->status_pesanan = $request->status_pesanan;
        $bb->harga_satuan = $harga_satuan;
        $bb->total_harga = $jumlah_pesanan * $harga_satuan;
        $bb->save();

        return redirect()->route('pemesanan.index');
    }

    public function edit($id)
    {
        $bb = PemesananBahanBaku::find($id);

        return view('pemesanan-bahan-baku.pemesanan-edit', compact('bb'));
    }

    public function update($id, Request $request)
    {
        $bb = PemesananBahanBaku::find($id);

        $jumlah_pesanan = $request->jumlah_pesanan;
        $harga_satuan = $request->harga_satuan;
        $bb->nama_bahan_baku = $request->nama_bahan_baku;
        $bb->jumlah_pesanan = $jumlah_pesanan;
        $bb->status_pesanan = $request->status_pesanan;
        $bb->harga_satuan = $harga_satuan;
        $bb->total_harga = $jumlah_pesanan * $harga_satuan;
        $bb->save();
        return redirect()->route('pemesanan.index');
    }

    public function delete($id)
    {
        $bb = PemesananBahanBaku::find($id);
        $bb->delete();

        return redirect()->route('pemesanan.index');
    }

    public function updateStok($stok)
    {
        # code...
    }
}
