<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\KeuanganHarian;
use Yajra\DataTables\DataTables;


class KeuanganHarianController extends Controller
{

    public function index(Request $request)
    {


        if ($request->ajax()) {
            // $user = auth()->user();

            $data = KeuanganHarian::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {
                    if ($row->type == 'Pengeluaran') {
                        return '<button class="btn btn-sm btn-primary">Pengeluaran</button>';
                    } else {
                        return '<button class="btn btn-sm btn-info">Pemasukkan</button>';
                    }
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('nama_toko')) {
                        $instance->where('toko', $request->nama_toko);
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('toko', 'LIKE', "%$search%")
                                ->orWhere('tanggal', 'LIKE', "%$search%")
                                ->orWhere('type', 'LIKE', "%$search%")
                                ->orWhere('uraian', 'LIKE', "%$search%")
                                ->orWhere('kode_akun', 'LIKE', "%$search%")
                                ->orWhere('nominal', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '';

                    // if ($user->can('pemesanan_bahan_baku-edit')) {
                    $btn .= '<a href="' . route("keuangan-harian.edit", $row->id) . '" data-toggle="tooltip" title="Edit" class="btn btn-warning mr-1 btn-sm edit-btn">Edit </a>';
                    // }

                    // if ($user->can('pemesanan_bahan_baku-delete')) {
                    $btn .= '<a href="#" data-id="' . $row->id . '"  title="Delete" class="btn btn-danger btn-sm " id="delete-btn">Hapus</a>';
                    // }
                    return $btn;
                })
                ->editColumn('tanggal', function ($row) {
                    return [
                        'tanggal' => Carbon::parse($row->tanggal)->locale('id')->isoFormat('dddd, DD MMMM YYYY'),
                        'timestamp' => $row->tanggal
                    ];
                })

                ->rawColumns(['type','action'])

                ->make(true);
        }

        return view('dashboard.harian.harian-index');
    }


    public function create()
    {
        return view('dashboard.harian.harian-create');
    }


    public function store(Request $request)
    {

        KeuanganHarian::create($request->all());
        return redirect()->route('keuangan-harian.index');
    }


    public function edit($id)
    {
        $keuangan = KeuanganHarian::find($id);
        return view('dashboard.harian.harian-edit', compact('keuangan'));
    }

    public function update(Request $request, $id)
    {
        $keuangan = KeuanganHarian::find($id);
        $keuangan->update($request->all());
        return redirect()->route('keuangan-harian.index');
    }

    public function destroy($id)
    {
        $keuangan = KeuanganHarian::find($id);

        $keuangan->delete();
        return redirect()->route('keuangan-harian.index');
    }
}
