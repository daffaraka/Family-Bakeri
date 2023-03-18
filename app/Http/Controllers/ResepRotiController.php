<?php

namespace App\Http\Controllers;

use App\Models\ResepRoti;
use Illuminate\Http\Request;

class ResepRotiController extends Controller
{
    public function index()
    {
        $resep = ResepRoti::all();
        return view('resep-roti.resep-index',compact('resep'));
    }

    public function create()
    {
        return view('resep-roti.resep-create');
    }

    public function store(Request $request)
    {
        $resep = new ResepRoti();
    }

    public function show(ResepRoti $resepRoti)
    {
        //
    }

    public function edit(ResepRoti $resepRoti)
    {
        //
    }

    public function update(Request $request, ResepRoti $resepRoti)
    {
        //
    }

    public function destroy(ResepRoti $resepRoti)
    {
        //
    }
}
