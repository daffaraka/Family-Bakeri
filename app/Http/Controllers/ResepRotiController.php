<?php

namespace App\Http\Controllers;

use App\Models\ResepRoti;
use App\Models\StokBahanBaku;
use Illuminate\Http\Request;

class ResepRotiController extends Controller
{
    public function index()
    {
        $resep = ResepRoti::all();


        return view('resep-roti.resep-index', compact('resep'));
    }

    public function create()
    {
        $stok = StokBahanBaku::all();
        $stok_json = json_encode(StokBahanBaku::select(['id', 'nama_bahan_baku'])->get());

        return view('resep-roti.resep-create', compact('stok', 'stok_json'));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $nama_bahan = [];
        $nama_bahan = $request->nama_bahan_baku;
        $jumlah_bahan = $request->jumlah_bahan_baku;
        $input = [
            'nama_roti' => $request->nama_roti,
            'nama_bahan_baku' => $nama_bahan,
            'jumlah_bahan_baku' => $jumlah_bahan
        ];


        ResepRoti::create($input);




        return redirect()->route('resep.index');
    }

    public function show($id)
    {
        $resep = ResepRoti::findOrFail($id);
        $html = "";
        if (!empty($resep)) {
            $html = "
            <h3> Resep " . $resep->nama_roti . "</h3> <br>
            <table class='table'>
            <thead>
                <tr>
                    <th>Nama Bahan Baku</th>
                    <th>Jumlah Bahan Baku</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>";
            foreach ($resep->nama_bahan_baku as $bb) {
                $html .= "- <b>  " . $bb . "</b> <br>";
            }
            $html .= "</td>
                    <td>";
            foreach ($resep->jumlah_bahan_baku as $jb) {
                $html .= "<b>" . $jb . "</b> <br>";
            }
            $html .= "
                    </td>
                </tr>
            </tbody>
            </table>";
        }

        $response['html'] = $html;
        return response()->json($response);
    }

    public function edit($id)
    {
        $stok = StokBahanBaku::all();
        $stok_json = json_encode(StokBahanBaku::select(['id', 'nama_bahan_baku'])->get());
        $resep = ResepRoti::find($id);
        $resep_bahan = $resep->nama_bahan_baku;
        $resep_select['nama_bahan_baku'] =  $resep->nama_bahan_baku;

        // $resep_select['nama_bahan_baku'] =  $resep->whereJsonContains('nama_bahan_baku',$resep_bahan)->get();
        // dd($resep_select);

        return view('resep-roti.resep-edit', compact('resep', 'stok', 'stok_json', 'resep_select'));
    }

    public function update(Request $request, $id)
    {
        dd($request->all());
    }

    public function delete($id)
    {
        $resep = ResepRoti::find($id);
        $resep->delete();
        return redirect()->route('resep.index');
    }
}
