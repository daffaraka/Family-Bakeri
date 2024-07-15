<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ResepRoti;
use Illuminate\Http\Request;
use App\Models\StokBahanBaku;
use App\Models\ResepBahanBaku;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ResepRotiController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:resep_roti-list|resep_roti-create|resep_roti-show|resep_roti-edit|resep_roti-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:resep_roti-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:resep_roti-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:resep_roti-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $resep = ResepRoti::all();


        return view('dashboard.resep-roti.resep-index', compact('resep'));
    }

    public function create()
    {
        $stok = StokBahanBaku::all();
        $stok_json = json_encode(StokBahanBaku::select(['id', 'nama_bahan_baku'])->get());

        return view('dashboard.resep-roti.resep-create', compact('stok', 'stok_json'));
    }

    public function store(Request $request)
    {

        $ppn = 0;
        $jumlah_bahan_baku = $request->jumlah_bahan_baku;

        if ($request->ppn == 'Ya') {
            $ppn = 2000;
        } else {
            $ppn = 0;
        }

        $validator = Validator::make($request->all(), [
            'nama_bahan_baku' => 'required',
            'jumlah_bahan_baku' => 'required',
        ], [
            'nama_bahan_baku.required' => 'Stok bahan baku dibutuhkan dan harus di isi.',
            'jumlah_bahan_baku.required' => 'Jumlah bahan baku harus diisi',

        ]);


        if ($validator->fails()) {
            if ($validator->errors())
                Alert::error('', '');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            for ($i = 0; $i < count($request->nama_bahan_baku); $i++) {
                if ($request->satuan[$i] == 'Kg') {
                    $jumlah_bahan_baku[$i] = $jumlah_bahan_baku[$i] * 1000;
                }
            }

            $file = $request->file('gambar_roti');

            $fileName = $file->getClientOriginalName();
            $fileSaved =  $request->nama_resep_roti . '-' . now()->format('Y-m-d H-i-s') . '-' . $fileName;

            $file->move('images/Resep Roti', $request->nama_resep_roti . '-' . $fileName);
            $resepRoti = new ResepRoti;
            $resepRoti->harga = $request->harga;
            $resepRoti->nama_resep_roti = $request->nama_resep_roti;
            $resepRoti->ppn = $ppn;
            $resepRoti->gambar_roti = $fileSaved;
            $resepRoti->save();


            for ($i = 0; $i < count($request->nama_bahan_baku); $i++) {
                // dd($jbb_satuan);
                $resepBahanBaku = new ResepBahanBaku;
                $resepBahanBaku->resep_roti_id = $resepRoti->id;
                $resepBahanBaku->stok_bahan_baku_id = $request->nama_bahan_baku[$i];
                $resepBahanBaku->jumlah_bahan_baku =  $jumlah_bahan_baku[$i];
                $resepBahanBaku->satuan = $request->satuan[$i];
                $resepBahanBaku->save();
            }

            alert()->success('Berhasil', 'Resep Baru Berhasil Ditambahkan');
            return redirect()->route('resep.index');
        }
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
                        <td>" . $bb->satuan  . " </td>
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



        return view('dashboard.resep-roti.resep-edit', compact('resep', 'stok', 'stok_json', 'resep_select'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'gambar_roti' => 'mimes:jpg,jpeg,png',
        ]);

        $resepRoti = ResepRoti::find($id);
        if (empty($resepRoti)) {
            return response()->json(['message' => 'Resep Roti tidak ditemukan'], 404);
        }

        // Untuk File
        $file = $request->file('gambar_roti');
        $fileSaved = '';
        if ($file != null) {
            $fileName = $file->getClientOriginalName();
            $fileSaved =  $request->nama_resep_roti . '-' . now()->format('Y-m-d H-i-s') . '-' . $fileName;
            if ($file) {
                if (File::exists(public_path('images/Resep Roti/' . $resepRoti->gambar_roti))) {
                    File::delete(public_path('images/Resep Roti/' . $resepRoti->gambar_roti));
                    $file->move('images/Resep Roti', $fileSaved);
                } else {
                    $file->move('images/Resep Roti', $fileSaved);
                }
            }
        } else {
            $fileSaved = $resepRoti->gambar_roti;
        }




        $ppn = 0;

        if ($request->ppn == 'Ya') {
            $ppn = 2000;
        } else {
            $ppn = 0;
        }

        $resepRoti->nama_resep_roti = $request->input('nama_resep_roti');
        $resepRoti->ppn = $ppn;
        $resepRoti->harga = $request->harga;
        $resepRoti->gambar_roti = $fileSaved;
        $resepRoti->save();

        // Update pivot table ResepBahanBaku
        if ($request->has('nama_bahan_baku')) {
            $namaBahanBaku = $request->nama_bahan_baku;
            $jumlahBahanBaku = $request->jumlah_bahan_baku;

            // Delete existing pivot records
            $resepRoti->bahanBaku()->detach();

            // Insert updated pivot records
            for ($i = 0; $i < count($namaBahanBaku); $i++) {
                $satuan = $request->satuan[$i];

                $resepRoti->bahanBaku()->attach(
                    $namaBahanBaku[$i],
                    [
                        'jumlah_bahan_baku' => $jumlahBahanBaku[$i],
                        'satuan' => $satuan
                    ]
                );
            }
        }
        alert()->success('Berhasil', 'Resep Berhasil Diperbarui');

        return redirect()->route('resep.index');
    }

    public function delete($id)
    {
        $resep = ResepRoti::find($id);
        $resep->delete();
        alert()->success('Berhasil', 'Data Berhasil dihapus');

        return redirect()->route('resep.index');
    }

    public function getDataSatuan(Request $request)
    {
        $data['satuan'] = StokBahanBaku::where('nama_bahan_baku', $request->nama_bahan_baku)->first();
        return response()->json($data);
    }
}
