<?php

namespace App\Http\Controllers;

use App\Models\ResepRoti;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index()
    {
        $data = ResepRoti::all();

        return view('front-end.beranda', compact('data'));
    }

    public function buatPesanan($id)
    {
        $data = ResepRoti::find($id);

        return view('front-end.buat-pesanan',compact('data'));
    }

    public function storePesanan(Request $request, $id)
    {

    }
}
