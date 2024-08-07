<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\StokBahanBaku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class StokBahanBakuController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:stok_bahan_baku-list|
                        stok_bahan_baku-create|stok_bahan_baku-edit|
                        stok_bahan_baku-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:stok_bahan_baku-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:stok_bahan_baku-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:stok_bahan_baku-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $stok = StokBahanBaku::all();

        return view('dashboard.stok-bahan-baku.stok-index', compact('stok'));
    }

    public function create()
    {
        return view('dashboard.stok-bahan-baku.stok-create');
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama_bahan_baku' => 'required|unique:stok_bahan_bakus,nama_bahan_baku,NULL,id,deleted_at,NULL',
            'jumlah' => 'required|min:0',
            'satuan' => 'required',
        ], [
            'nama_bahan_baku.required' => 'Nama bahan baku harus diisi.',
            'nama_bahan_baku.unique' => 'Nama bahan baku sudah terdaftar.',
            'jumlah.required' => 'Jumlah bahan baku harus diisi.',
            'jumlah.min' => 'Jumlah bahan baku harus lebih dari atau sama dengan 0.',
            'satuan.required' => 'Satuan bahan baku harus diisi.',
        ]);

        $jumlah_min = $request->jumlah_minimal;
        $jumlah =  $request->jumlah;

        // dd($jumlah * 1000);
        // Jika validasi gagal
        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($request->satuan == 'Kg') {
                $jumlah = $request->jumlah * 1000;
                $jumlah_min = $request->jumlah_minimal * 1000;
            }


            StokBahanBaku::create(
                [
                    'nama_bahan_baku' => $request->nama_bahan_baku,
                    'jumlah_minimal' =>   $jumlah_min,
                    'jumlah' => $jumlah,
                    'satuan' => $request->satuan,
                    'terakhir_diedit_by' => Auth::user()->name ?? 'Test',
                ]
            );


            Alert::success('Berhasil');
            return redirect()->route('stok.index');
        }
    }

    public function edit($id)
    {
        $stok = StokBahanBaku::find($id);

        $jb = 0;
        $jm = 0;


        if ($stok->satuan == 'Kg') {
            $jb = $stok->jumlah / 1000;
            $jm = $stok->jumlah_minimal / 1000;
        } else {
            $jb = $stok->jumlah;
            $jm = $stok->jumlah_minimal;
        }

        return view('dashboard.stok-bahan-baku.stok-edit', compact('stok', 'jb', 'jm'));
    }

    public function update(Request $request, $id)
    {
        $stok = StokBahanBaku::find($id);
        // $raw_jm = str_replace(',', '', $request->jumlah_minimal);

        // $jumlah_minimal = intval($raw_jm);
        // $jumlah_minimal = ;
        $jumlah_minimal = $request->jumlah_minimal;

        $jumlah = $request->jumlah;


        if ($request->satuan == 'Kg' && is_numeric($request->jumlah)) {
            $jumlah = $request->jumlah * 1000;
        } else {
            $jumlah = str_replace([',', '.'], '', $request->jumlah);
        }

        if ($request->satuan == 'Kg' && is_numeric($request->jumlah_minimal)) {
            $jumlah_minimal = $request->jumlah_minimal * 1000;
        } else {
            $jumlah_minimal = str_replace([',', '.'], '', $request->jumlah_minimal);
        }

        $stok->nama_bahan_baku = $request->nama_bahan_baku;
        $stok->jumlah_minimal = $jumlah_minimal;
        $stok->jumlah = $jumlah;
        $stok->satuan = $request->satuan;
        $stok->terakhir_diedit_by =  Auth::user()->name ?? 'Test';
        $stok->save();

        if (!$stok) {
            Alert::error('Gagal diperbarui');
            return redirect()->back();
        } else {
            Alert::success('Berhasil diperbarui');
            return redirect()->route('stok.index');
        }
    }


    public function delete($id)
    {
        $stok = StokBahanBaku::find($id);
        $stok->delete();
        Alert::success('Berhasil dihaus');
        return redirect()->route('stok.index');
    }
}
