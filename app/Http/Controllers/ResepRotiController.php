<?php

namespace App\Http\Controllers;

use App\Models\ResepBahanBaku;
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
        $resepRoti = new ResepRoti;
        $resepRoti->nama_resep_roti = $request->nama_resep_roti;
        $resepRoti->save();


        for ($i = 0; $i < count($request->nama_bahan_baku); $i++) {
            $resepBahanBaku = new ResepBahanBaku;
            $resepBahanBaku->resep_roti_id = $resepRoti->id;
            $resepBahanBaku->stok_bahan_baku_id = $request->nama_bahan_baku[$i];
            $resepBahanBaku->jumlah_bahan_baku = $request->jumlah_bahan_baku[$i];
            $resepBahanBaku->satuan = $request->satuan[$i];
            $resepBahanBaku->save();
        }
        return redirect()->route('resep.index');
    }

    public function show($id)
    {
        $resep = ResepRoti::with('resepBahanBakus.bahanBaku')->find($id);

        // dd($resep);
        $html = "";
        if (!empty($resep)) {
            $html = "
            <h3> Resep " . $resep->nama_resep_roti . "</h3> <br>
            <table class='table'>
            <thead>
                <tr>
                    <th>Nama Bahan Baku</th>
                    <th> Jumlah Bahan Baku </th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($resep->resepBahanBakus as $bb)
                $html .= "
                <tr>
                        <td>" . $bb->bahanBaku->nama_bahan_baku . "</td>
                        <td>" . $bb->jumlah_bahan_baku . "</td>
                        <td>" . $bb->satuan . " </td>
                </tr>";
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
        $resep = ResepRoti::with(['resepBahanBakus.bahanBaku'])->find($id);
        $resep_select =  $resep;



        return view('resep-roti.resep-edit', compact('resep', 'stok', 'stok_json', 'resep_select'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $resepRoti = ResepRoti::find($id);
        if (empty($resepRoti)) {
            return response()->json(['message' => 'Resep Roti tidak ditemukan'], 404);
        }
        $resepRoti->nama_resep_roti = $request->input('nama_resep_roti');
        $resepRoti->save();

        // Update pivot table ResepBahanBaku
        if ($request->has('nama_bahan_baku')) {
            $namaBahanBaku = $request->nama_bahan_baku;
            $jumlahBahanBaku = $request->jumlah_bahan_baku;

            // Delete existing pivot records
            $resepRoti->bahanBaku()->detach();

            // Insert updated pivot records
            for ($i=0; $i < count($namaBahanBaku); $i++) {
                $stokBahanBaku = StokBahanBaku::where('id',$namaBahanBaku[$i])->get();

                $satuan = $stokBahanBaku[0]->satuan;

                $resepRoti->bahanBaku()->attach($namaBahanBaku[$i], ['jumlah_bahan_baku' => $jumlahBahanBaku[$i], 'satuan' => $satuan]);
            }
        }

        return redirect()->route('resep.index');
    }

    public function delete($id)
    {
        $resep = ResepRoti::find($id);
        $resep->delete();
        return redirect()->route('resep.index');
    }
}
