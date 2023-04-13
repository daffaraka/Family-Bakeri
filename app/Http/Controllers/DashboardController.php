<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use App\Models\ResepRoti;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {

        $kasir = Kasir::all();
        return view('dashboard',compact('kasir'));
    }

    public function create()
    {
        $resep = ResepRoti::all();
        return view('kasir.kasir-create',compact('resep'));
    }
}
