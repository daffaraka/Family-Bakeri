<?php

namespace App\Http\Controllers;

use App\Models\PemesananBahanBaku;
use App\Models\StokBahanBaku;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PemesananBahanBakuController extends Controller
{

    public function index(Request $request)
    {
        // $bb = PemesananBahanBaku::all();

        // if ($request->status_pesanan) {
        //     $bb = $bb->where('status_pesanan', $request->status);
        // }

        // return view('pemesanan-bahan-baku.pemesanan-index', compact('bb'));

        if ($request->ajax()) {
            $data = PemesananBahanBaku::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status_pesanan', function ($row) {
                    if ($row->status_pesanan == 'Diterima') {
                        return '<button class="btn btn-primary">Diterima</button>';
                    } else if ($row->status_pesanan == 'Dibayar') {
                        return '<button class="btn btn-info">Dibayar</button>';
                    } else {
                        return '<button class="btn btn-info">Sedang Diantar</button>';
                    }
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == 'Diterima' || $request->get('status') == 'Dibayar'  || $request->get('status') == 'Sedang Diantar') {
                        $instance->where('status_pesanan', $request->get('status'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('nama_bahan_baku', 'LIKE', "%$search%")
                                ->orWhere('harga_satuan', 'LIKE', "%$search%")
                                ->orWhere('jumlah_pesanan', 'LIKE', "%$search%")
                                ->orWhere('status_pesanan', 'LIKE', "%$search%")
                                ->orWhere('total_harga', 'LIKE', "%$search%")
                                ->orWhere('created_at', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="'.route("pemesanan.edit",['id'=>$row->id]).'"data-original-title="Detail" class="btn btn-warning mr-1 btn-sm ">Edit</a>
                    <a href="'.route("pemesanan.delete",['id'=>$row->id]).'"data-original-title="Detail" class="btn btn-danger mr-1 btn-sm ">Hapus</a>';

                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return [
                        'display' => Carbon::parse($row->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY'),
                        'timestamp' => $row->created_at->timestamp
                    ];
                 })
                ->rawColumns(['status_pesanan', 'action'])

                ->make(true);
        }

        return view('pemesanan-bahan-baku.pemesanan-index');

    }

    public function create()
    {
        $stok = StokBahanBaku::all();
        return view('pemesanan-bahan-baku.pemesanan-create', compact('stok'));
    }

    public function store(Request $request)
    {

        $bb = new PemesananBahanBaku();

        $stok = new StokBahanBaku();

        $req_bahan = $request->nama_bahan_baku;
        $cekStok = StokBahanBaku::firstWhere('nama_bahan_baku', $req_bahan);

        if ($request->status_pesanan == 'Diterima' && $cekStok) {
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
