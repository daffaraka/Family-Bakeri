<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kasir;
use App\Models\ResepRoti;
use App\Models\ProduksiRoti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KasirController extends Controller
{
    public function index(Request $request)
    {

        $roti = ProduksiRoti::all();

        $total = [];
        $now = Carbon::now()->format('Y-m-d');

        $total_penjualan = 0;


        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                // $total['roti'] = Kasir::where('tanggal_diproduksi', $request->from_date)->sum(DB::raw('total_rizky + total_palem + total_moro_jaya'));
                $data = DB::table('kasirs')
                    ->where('tanggal_diproduksi', $request->from_date)
                    ->get();
                // } else if ($request->getAll) {
                $total_penjualan = Kasir::where('tanggal_diproduksi', $request->from_date)->sum('total_penjualan');
                $total_pesanan = Kasir::where('tanggal_diproduksi', $request->from_date)->sum('total_pesanan');
                $pemotongan = Kasir::where('tanggal_diproduksi', $request->from_date)->sum('pemotongan');
                $sub_total = Kasir::where('tanggal_diproduksi', $request->from_date)->sum('sub_total');
            } else {
                // $total['roti'] = Kasir::where('tanggal_diproduksi', $request->from_date)->sum(DB::raw('total_rizky + total_palem + total_moro_jaya'));
                $data = DB::table('kasirs')
                    ->where('tanggal_diproduksi', $now)
                    ->get();
                $total_penjualan = Kasir::where('tanggal_diproduksi', $now)->sum('total_penjualan');
                $total_pesanan = Kasir::where('tanggal_diproduksi', $now)->sum('total_pesanan');
                $pemotongan = Kasir::where('tanggal_diproduksi', $now)->sum('pemotongan');
                $sub_total = Kasir::where('tanggal_diproduksi', $now)->sum('sub_total');
            }
            return datatables()->of($data)->addColumn('tanggal_diproduksi', function ($row) {
                // Mengambil nilai tanggal_diproduksi
                $tanggalDiproduksi = $row->tanggal_diproduksi;
                // Mengubah format tanggal menjadi Nama Hari, tanggal bulan tahun
                $namaHari = \Carbon\Carbon::parse($tanggalDiproduksi)->locale('id')->translatedFormat('l', 'id');
                $tanggalBulanTahun = \Carbon\Carbon::parse($tanggalDiproduksi)->format('d F Y');
                $formattedDate = $namaHari . ', ' . $tanggalBulanTahun;
                return $formattedDate;
            })->with('total_penjualan', function () use ($total_penjualan) {
                return $total_penjualan;
            })->with('total_pesanan', function () use ($total_pesanan) {
                return $total_pesanan;
            })->with('pemotongan', function () use ($pemotongan) {
                return $pemotongan;
            })->with('sub_total', function () use ($sub_total) {
                return $sub_total;
            })
                ->make(true);
        }

        return view('kasir.kasir-index', compact('roti', 'total_penjualan'));
    }

    public function getDataRoti(Request $request)
    {
        $data['roti'] = ResepRoti::with('ProduksiRoti')->where('nama_resep_roti', $request->nama_resep_roti)->first();
        return response()->json($data);
    }

    public function getDataByDate(Request $request)
    {

        $kasir = Kasir::query(); // Menggunakan query builder untuk membangun query

        if ($request->ajax()) {
            if ($request->has('from_date')) {
                // Melakukan filter berdasarkan rentang tanggal
                $kasir->whereDate('tanggal_diproduksi', '=', $request->from_date);
            }
        }

        $kasir = $kasir->get();

        return response($kasir);
    }

    public function tes()
    {

        dd(Kasir::all());
    }


    public function store(Request $request)
    {




        // $pesanan = $request->input('pesanan');
        $pemesan = $request->input('pemesan');
        $sisa_total = $request->input('sisa');
        $nama_resep_roti = $request->input('nama_roti');


        $resep = ResepRoti::where('nama_resep_roti', $request->nama_roti)->first();
        $produksiRoti = ProduksiRoti::where('nama_roti', $nama_resep_roti)->first();


        //
        $tanggal_sekarang = Carbon::now()->format('Y-m-d');

        if ($request->pemesanan == 'Rizky') {
            $pemesan = 'Rizky';
        }
        if ($request->pemesanan == 'Palem') {
            $pemesan = 'Palem';
        }
        if ($request->pemesanan == 'Moro Joyo') {
            $pemesan = 'Moro Joyo';
        }



        // if ($pesanan == 'Ya') {
        // Jika pesanan adalah 'Ya', maka kurangi sisa produksi roti dengan nilai dari input #sisa_total

        // Simpan data kasir dengan informasi pesanan
        $kasir = new Kasir();
        $kasir->nama_roti = $nama_resep_roti;
        $kasir->harga = $request->input('harga');
        $kasir->stok_masuk = $produksiRoti->jumlah_produksi;
        $kasir->jumlah = $produksiRoti->jumlah_produksi;
        $kasir->laku = $request->input('laku');
        $kasir->ppn = $resep->ppn;
        $kasir->sisa_total = $sisa_total;
        $kasir->rizky = $pemesan == 'Rizky' ?  $request->input('laku') : 0;   // tambahkan kolom untuk Rizky
        $kasir->palem = $pemesan == 'Palem' ?  $request->input('laku') : 0; // tambahkan kolom untuk Palem
        $kasir->moro_jaya = $pemesan == 'Moro Jaya' ?  $request->input('laku') : 0; // tambahkan kolom untuk Moro Jaya
        $kasir->total_rizky = $kasir->rizky;
        $kasir->total_palem = $kasir->palem * $request->harga;
        $kasir->total_moro_jaya =  $kasir->moro_jaya * $request->harga;
        $kasir->total_penjualan = $request->harga * $request->laku;
        $kasir->tanggal_diproduksi  = $tanggal_sekarang;
        $kasir->save();

        $produksiRoti->jumlah_produksi -= $request->input('laku');
        $produksiRoti->save();

        // } else if ($pesanan == 'Tidak') {
        //     // Jika pesanan adalah 'Tidak', maka kurangi sisa produksi roti dengan nilai dari input #sisa_total
        //     $produksiRoti->jumlah_produksi -= $sisa_total;
        //     $produksiRoti->save();

        //     // Simpan data kasir dengan informasi bukan pesanan
        //     $kasir = new Kasir();
        //     $kasir->nama_roti = $nama_resep_roti;
        //     $kasir->harga = $request->input('harga');
        //     $kasir->stok_masuk = $request->input('stok_masuk');
        //     $kasir->laku = $request->input('laku');
        //     $kasir->sisa_total = $sisa_total;
        //     $kasir->rizky = 0; // tambahkan kolom untuk Rizky
        //     $kasir->palem = 0; // tambahkan kolom untuk Palem
        //     $kasir->moro_jaya = 0; // tambahkan kolom untuk Moro Jaya
        //     $kasir->save();
        // }
        return redirect()->back()->with('success', 'Data kasir berhasil disimpan.');
    }

    public function updateStokTersisa()
    {
        // Mendapatkan waktu sekarang dalam bentuk objek Carbon
        $carbon = new Carbon;

        // Update data Kasir
        $kasir = Kasir::where('sisa_total', '>', 0)->whereDate('tanggal_diproduksi', '=', $carbon->now());


        $kasir =  $kasir->update(['tanggal_diproduksi' => $carbon->addDay(1)]);

        if ($kasir) {
            Alert::success('Success', 'Data telah diperbarui');
        } else {

            Alert::error('Kesalahan', 'Data tidak dapat diperbarui');
        }

        return redirect()->back();
    }
}
