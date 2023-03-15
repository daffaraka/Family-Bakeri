<?php

namespace App\Http\Controllers;

use App\Models\StokBahanBaku;
use Illuminate\Http\Request;

class Select2Controller extends Controller
{


    public function searchStokBahanBaku(Request $request)
    {
        $stok = [];
        if ($request->has('query')) {
            $search = $request->query;
            $stok = StokBahanBaku::select('id', 'nama_bahan_baku')
                    ->where('nama_bahan_Baku', 'LIKE', "%$search%")->get();
        }

        return response()->json($stok);
    }
}
