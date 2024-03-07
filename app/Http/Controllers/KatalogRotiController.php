<?php

namespace App\Http\Controllers;

use App\Models\ResepRoti;
use App\Models\KatalogRoti;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class KatalogRotiController extends Controller
{

    public function index()
    {
        $data = KatalogRoti::with('resepRoti')->get();
        return view('dashboard.katalog-roti.katalog-index',compact('data'));
    }

    public function create()
    {
        $resep = ResepRoti::whereDoesntHave('katalogRoti')->get();
        return view('dashboard.katalog-roti.katalog-create',compact('resep'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'resep_roti_id' => 'unique:katalog_rotis,resep_roti_id'
        ],[
            'resep_roti_id.unique' => 'Katalog Telah Ditambahkan'
        ]);
        if($validator->fails()){

            return response()->json($validator->errors(), 422);
        }

        $katalogRoti = new KatalogRoti();
        $katalogRoti->resep_roti_id = $request->resep_roti;
        $katalogRoti->stok = 0;
        $katalogRoti->laku = 0;
        $katalogRoti->deskripsi = $request->deskripsi;
        $katalogRoti->save();

        alert()->success('Berhasil','Data katalog telah ditambahkan');
        return redirect()->route('katalog.index');
    }

    public function edit($id)
    {

        $resep = ResepRoti::all();

        $katalog = KatalogRoti::find($id);

        return view('dashboard.katalog-roti.katalog-edit',compact('katalog','resep'));
    }

    public function update(Request $request, $id)
    {

        $katalog = KatalogRoti::find($id);
        $validator = Validator::make($request->all(),[
            'resep_roti_id' => 'unique:katalog_rotis,resep_roti_id,'.$id
        ],[
            'resep_roti_id.unique' => 'Katalog Telah Ditambahkan'
        ]);

        if($validator->fails()){

            return response()->json($validator->errors(), 422);
        }

        $katalog->resep_roti_id = $request->resep_roti;
        $katalog->stok = $katalog->stok;
        $katalog->laku = $katalog->laku;
        $katalog->deskripsi = $request->deskripsi;
        $katalog->save();

        alert()->success('Berhasil','Data katalog berhasil diperbarui');
        return redirect()->route('katalog.index');
    }

    public function destroy($id)
    {
        $katalog = KatalogRoti::find($id);

        $katalog->delete();

        alert()->success('Berhasil','Data Berhasil dihapus');

        return redirect()->route('katalog.index');
    }
}
