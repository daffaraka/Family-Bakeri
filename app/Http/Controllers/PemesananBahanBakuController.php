<?php

namespace App\Http\Controllers;

use App\Models\PemesananBahanBaku;
use App\Models\StokBahanBaku;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PemesananBahanBakuController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pemesanan_bahan_baku-list|pemesanan_bahan_baku-create|pemesanan_bahan_baku-edit|pemesanan_bahan_baku-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:pemesanan_bahan_baku-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pemesanan_bahan_baku-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pemesanan_bahan_baku-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // $bb = PemesananBahanBaku::all();

        // if ($request->status_pesanan) {
        //     $bb = $bb->where('status_pesanan', $request->status);
        // }

        // return view('pemesanan-bahan-baku.pemesanan-index', compact('bb'));

        if ($request->ajax()) {
            $user = auth()->user();

            $data = PemesananBahanBaku::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status_pesanan', function ($row) {
                    if ($row->status_pesanan == 'Diterima') {
                        return '<button class="btn btn-sm btn-primary">Diterima</button>';
                    } else if ($row->status_pesanan == 'Dibayar') {
                        return '<button class="btn btn-sm btn-info">Dibayar</button>';
                    } else {
                        return '<button class="btn btn-sm btn-info">Sedang Diantar</button>';
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
                ->addColumn('action', function ($row) use ($user) {
                    $btn = '';

                    if ($user->can('pemesanan_bahan_baku-edit')) {
                        $btn .= '<a href="'.route("pemesanan.edit",$row->id).'" data-toggle="tooltip" title="Edit" class="btn btn-warning mr-1 btn-sm">Edit </a>';
                    }

                    if ($user->can('pemesanan_bahan_baku-delete')) {
                        $btn .= '<a href="'.route("pemesanan.delete",$row->id).'" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-sm delete">Hapus</a>';
                    }
                    return $btn;
                })
                ->editColumn('deadline_dp', function ($row) {
                    return [
                        'display' => Carbon::parse($row->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY'),
                        'timestamp' => $row->deadline_dp
                    ];
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

        $jumlah_pesanan = $request->jumlah_pesanan;
        $harga_satuan = $request->harga_satuan;

        $req_bahan = $request->nama_bahan_baku;
        $cekStok = StokBahanBaku::firstWhere('nama_bahan_baku', $req_bahan);

        if ($request->status_pesanan == 'Diterima' && $cekStok) {
            $cekStok->jumlah = $cekStok->jumlah + $request->jumlah_pesanan;
            $cekStok->save();
        }

        $total_harga = $jumlah_pesanan * $harga_satuan;

        if($request->dp >= 0) {
            $sisa_pembayaran = $total_harga - $request->dp;
        }


        $bb->nama_bahan_baku = $request->nama_bahan_baku;
        $bb->jumlah_pesanan = $jumlah_pesanan;
        $bb->dp = $request->dp;
        $bb->deadline_dp = $request->deadline_dp;
        $bb->status_pesanan = $request->status_pesanan;
        $bb->harga_satuan = $harga_satuan;
        $bb->total_harga = $total_harga;
        $bb->sisa_pembayaran = $sisa_pembayaran;
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

        $req_bahan = $request->nama_bahan_baku;
        $cekStok = StokBahanBaku::firstWhere('nama_bahan_baku', $req_bahan);

        $jumlah_pesanan = $request->jumlah_pesanan;
        $harga_satuan = $request->harga_satuan;

        if ($request->status_pesanan == 'Diterima' && $cekStok) {
            $cekStok->jumlah = $cekStok->jumlah + $request->jumlah_pesanan;
            $cekStok->save();
        }

        $total_harga = $jumlah_pesanan * $harga_satuan;

        if($request->dp >= 0) {
            $sisa_pembayaran = $total_harga - $request->dp;
        }


        $bb->nama_bahan_baku = $request->nama_bahan_baku ?? $bb->nama_bahan_baku;
        $bb->jumlah_pesanan = $jumlah_pesanan;
        $bb->status_pesanan = $request->status_pesanan;
        $bb->harga_satuan = $harga_satuan;
        $bb->dp = $request->dp;
        $bb->deadline_dp = $request->deadline_dp;
        $bb->total_harga = $total_harga;
        $bb->sisa_pembayaran = $sisa_pembayaran;

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
