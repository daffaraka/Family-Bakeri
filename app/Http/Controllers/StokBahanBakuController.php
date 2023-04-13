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
    public function index()
    {
        $stok = StokBahanBaku::all();

        return view('stok-bahan-baku.stok-index', compact('stok'));
    }

    public function create()
    {
        return view('stok-bahan-baku.stok-create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_bahan_baku' => 'required|unique:stok_bahan_bakus,nama_bahan_baku',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required',
        ], [
            'nama_bahan_baku.required' => 'Nama bahan baku harus diisi.',
            'nama_bahan_baku.unique' => 'Nama bahan baku sudah terdaftar.',
            'jumlah.required' => 'Jumlah bahan baku harus diisi.',
            'jumlah.numeric' => 'Jumlah bahan baku harus berupa angka.',
            'jumlah.min' => 'Jumlah bahan baku harus lebih dari atau sama dengan 0.',
            'satuan.required' => 'Satuan bahan baku harus diisi.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            if ($validator->errors())
                Alert::error('', '');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $jumlah = $request->jumlah;
            if ($request->satuan == 'Kg') {
                $jumlah = $request->jumlah * 1000;
            }
            StokBahanBaku::create(
                [
                    'nama_bahan_baku' => $request->nama_bahan_baku,
                    'jumlah' => $jumlah,
                    'satuan' => $request->satuan,
                    'terakhir_diedit_by' => Auth::user()->name ?? 'Test',
                ]
            );


            Alert::success('Berhasil');
            return redirect()->route('stok.index');
        }
    }

    public function delete($id)
    {
        $stok = StokBahanBaku::find($id);
        $stok->delete();
        return redirect()->route('stok.index');
    }
}
