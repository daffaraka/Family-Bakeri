<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kasir;
use App\Models\ResepRoti;
use App\Models\ProduksiRoti;
use Illuminate\Http\Request;
use App\Models\StokBahanBaku;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KasirController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:kasir-list|kasir-create|kasir-edit|kasir-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:kasir-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:kasir-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:kasir-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $roti = ResepRoti::all();

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
                $total_penjualan = Kasir::where('tanggal_diproduksi', $request->from_date)->sum('total_penjualan_ini');
                $total_pemesanan = Kasir::where('tanggal_diproduksi', $now)->sum(DB::raw('total_rizky + total_palem + total_moro_jaya'));
                $total_ppn = Kasir::where('tanggal_diproduksi', $request->from_date)->sum('total_ppn');
                $total_toko = Kasir::where('tanggal_diproduksi', $request->from_date)->sum('total_toko');
                $total_after_ppn = Kasir::where('tanggal_diproduksi', $request->from_date)->sum('total_after_ppn');
            } else {
                // $total['roti'] = Kasir::where('tanggal_diproduksi', $request->from_date)->sum(DB::raw('total_rizky + total_palem + total_moro_jaya'));
                $data = DB::table('kasirs')
                    ->where('tanggal_diproduksi', $now)
                    ->get();
                $total_penjualan = Kasir::where('tanggal_diproduksi', $now)->sum('total_penjualan_ini') ?? 0;
                $total_pemesanan = Kasir::where('tanggal_diproduksi', $now)->sum(DB::raw('total_rizky + total_palem + total_moro_jaya'));
                $total_ppn = Kasir::where('tanggal_diproduksi', $now)->sum('total_ppn') ?? 0;
                $total_toko = Kasir::where('tanggal_diproduksi', $now)->sum('total_toko') ?? 0;
                $total_after_ppn = Kasir::where('tanggal_diproduksi', $now)->sum('total_after_ppn') ?? 0;
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
            })->with('total_pemesanan', function () use ($total_pemesanan) {
                return $total_pemesanan;
            })->with('total_ppn', function () use ($total_ppn) {
                return $total_ppn;
            })->with('total_toko', function () use ($total_toko) {
                return $total_toko;
            })->with('total_after_ppn', function () use ($total_after_ppn) {
                return $total_after_ppn;
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


        $kasir = Kasir::where('nama_roti', $request->nama_roti)->first();


        // Nama Resep
        $nama_resep_roti = $request->input('nama_roti');

        $resep = ResepRoti::with('bahanBaku')->where('nama_resep_roti', $request->nama_roti)->first();
        $produksiRoti = ProduksiRoti::with('ResepRoti.bahanBaku')->where('nama_roti', $nama_resep_roti)->first();
        // Inisiasi harga
        $harga = $request->harga;


        $stokMasuk = $produksiRoti->where('nama_roti', $nama_resep_roti)->sum('stok_masuk');
        // Inisiasi pemesan
        $pemesan = $request->input('pemesan');
        // Inisiasi Sisa
        $sisa_total = $resep->stok_sekarang - $request->laku;

        // Inisiasi PPN
        $ppn = $resep->ppn;
        $tanggal_sekarang = Carbon::now()->format('Y-m-d');

        // Inisiasi Total Penjualan Ini

        $tpi = ($request->harga * $request->laku) + ($ppn * $request->laku);

        $laku = $request->laku;

        // Cek jika mempunyai ROti Off
        if($request->has('roti_off')) {
            if($request->roti_off < $resep->stok_sekarang) {
                Alert::error('Kesalahan', 'Stok roti tidak cukup');
                return redirect()->back();
            } else {
                $resep->stok_sekarang -= $request->roti_off;
                $resep->save();
            }

        }
        //  Mulai kondisi ketika terdapat data yang telah ADA
        //  Mulai kondisi ketika terdapat data yang telah ADA
        //  Mulai kondisi ketika terdapat data yang telah ADA
        //  Mulai kondisi ketika terdapat data yang telah ADA
        $result = $this->hitungTotalPenjualan($request,$resep, $produksiRoti);




        if ($kasir) {
            // INI UPDATE PEMESANAN
            if ($request->pemesanan == 'Rizky' || $request->pemesanan == 'Palem' || $request->pemesanan == 'Moro Jaya') {

                // return 'Ini Pemesanan ' . $request->pemesanan. ' Update';
                foreach ($resep->resepBahanBakus as $bahanBaku) {
                    // Hitung jumlah bahan baku yang dibutuhkan
                    $bahanBakuNeeded = $bahanBaku->jumlah_bahan_baku * $request->laku;

                    // Ambil stok bahan baku dari database
                    $stokBahanBaku = StokBahanBaku::findOrFail($bahanBaku->stok_bahan_baku_id);

                    // Periksa apakah stok cukup
                    if ($stokBahanBaku->jumlah == 0 || $stokBahanBaku->jumlah < $bahanBakuNeeded) {
                        // Jika stok tidak cukup, kembalikan response error

                        alert()->error('Kesalahan', 'Bahan Baku Tidak Cukup');
                        return redirect()->back();
                    }

                    // Kurangi stok bahan baku
                    $stokBahanBaku->jumlah -= $bahanBakuNeeded;
                    $stokBahanBaku->save();
                }

                $pemesan = $result['pemesan'];
                $ppn = $result['ppn'];
                $laku = $result['laku'];
                $tpi = $result['tpi'];

                $kasir->nama_roti = $nama_resep_roti;
                $kasir->stok_masuk = $stokMasuk;
                $kasir->stok_sekarang = $resep->stok_sekarang;
                $kasir->laku = $kasir->laku += $laku;
                $kasir->roti_off = $request->roti_off;
                $kasir->sisa_total = $kasir->sisa_total;
                $kasir->rizky = $pemesan == 'Rizky' ?  $kasir->rizky += $request->laku : $kasir->rizky;
                $kasir->palem =  $pemesan == 'Palem' ?  $kasir->palem += $request->laku : $kasir->palem;
                $kasir->moro_jaya = $pemesan == 'Moro Jaya' ?  $kasir->moro_jaya += $request->laku : $kasir->moro_jaya;
                $kasir->total_rizky =  $pemesan == 'Rizky' ? $kasir->total_rizky += $result['harga_pemesan'] * $request->laku : $kasir->total_rizky;
                $kasir->total_palem = $pemesan == 'Palem' ? $kasir->total_palem += $result['harga_pemesan'] * $request->laku : $kasir->total_palem;
                $kasir->total_moro_jaya = $pemesan == 'Moro Jaya' ? $kasir->total_moro_jaya += $result['harga_pemesan'] * $request->laku : $kasir->total_moro_jaya;
                $kasir->total_penjualan_ini = $kasir->total_penjualan_ini += $tpi;
                $kasir->total_ppn += $request->laku * $ppn;
                $kasir->tanggal_diproduksi  = $tanggal_sekarang;
                $kasir->save();
            } else {
                // Ini Update biasa
                if ($resep->stok_sekarang  == 0 || $resep->stok_sekarang < $request->laku) {
                    return redirect()->back()->with('warning', 'Stok roti tidak mencukupi pesanan');
                } else {
                    // dd('Ini biasa');
                    $kasir->nama_roti = $nama_resep_roti;
                    $kasir->stok_masuk = $stokMasuk;
                    $kasir->stok_sekarang = $resep->stok_sekarang;
                    $kasir->laku = $kasir->laku += $laku;
                    $kasir->roti_off = $request->roti_off;
                    $kasir->sisa_total = $request->sisa;
                    $kasir->rizky = $pemesan == 'Rizky' ?  $kasir->rizky += $request->laku : $kasir->rizky;
                    $kasir->palem =  $pemesan == 'Palem' ?  $kasir->palem += $request->laku : $kasir->palem;
                    $kasir->moro_jaya = $pemesan == 'Moro Jaya' ?  $kasir->moro_jaya += $request->laku : $kasir->moro_jaya;
                    $kasir->total_rizky =  $pemesan == 'Rizky' ? $kasir->total_rizky += $result['harga_pemesan'] * $request->laku : $kasir->total_rizky;
                    $kasir->total_palem = $pemesan == 'Palem' ? $kasir->total_palem += $result['harga_pemesan'] * $request->laku : $kasir->total_palem;
                    $kasir->total_moro_jaya = $pemesan == 'Moro Jaya' ? $kasir->total_moro_jaya += $result['harga_pemesan'] * $request->laku : $kasir->total_moro_jaya;
                    $kasir->total_penjualan_ini = $kasir->total_penjualan_ini += $tpi;
                    $kasir->total_ppn += $request->laku * $ppn;
                    $kasir->tanggal_diproduksi  = $tanggal_sekarang;
                    $kasir->save();

                    if ($request->pemesanan == null) {
                        $resep->stok_sekarang = $request->input('sisa');
                        $resep->laku += $request->input('laku');
                        $produksiRoti->save();
                    }
                }
            }


            // INI UPDATE YANG BIASA


            // Menyimpan data baru ke dalam tabel Kasir
            return redirect()->back()->with('success', 'Data ' . $kasir->nama_roti . ' kasir berhasil disimpan dan telah diperbarui.');
        }


        // JIKA TIDAK TERDAPAT DATA YANG ADA , MAKA INSERT DATA BARU
        // JIKA TIDAK TERDAPAT DATA YANG ADA , MAKA INSERT DATA BARU
        // JIKA TIDAK TERDAPAT DATA YANG ADA , MAKA INSERT DATA BARU
        // JIKA TIDAK TERDAPAT DATA YANG ADA , MAKA INSERT DATA BARU

        else {
            // JIka PEMESANAN
            if ($request->pemesanan == 'Rizky' || $request->pemesanan == 'Palem' || $request->pemesanan == 'Moro Jaya') {


                // return 'Ini Pemesanan ' . $request->pemesanan . ' Insert baru ';
                foreach ($resep->resepBahanBakus as $bahanBaku) {
                    // Hitung jumlah bahan baku yang dibutuhkan
                    $bahanBakuNeeded = $bahanBaku->jumlah_bahan_baku * $request->laku;

                    // Ambil stok bahan baku dari database
                    $stokBahanBaku = StokBahanBaku::findOrFail($bahanBaku->stok_bahan_baku_id);

                    // Periksa apakah stok cukup
                    if ($stokBahanBaku->jumlah == 0 || $stokBahanBaku->jumlah < $bahanBakuNeeded) {
                        // Jika stok tidak cukup, kembalikan response error

                        Alert::error('Kesalahan', 'Bahan Baku Tidak Cukup');
                        return redirect()->back();
                    }

                    // Kurangi stok bahan baku
                    $stokBahanBaku->jumlah -= $bahanBakuNeeded;
                    $stokBahanBaku->save();
                }
                $result = $this->hitungTotalPenjualan($request, $resep, $produksiRoti);
                $pemesan = $result['pemesan'];
                $harga_pemesan = $result['harga_pemesan'];
                $ppn = $result['ppn'];
                $laku = $result['laku'];
                $tpi = $result['tpi'];


                $newKasir = new Kasir();
                $newKasir->nama_roti = $nama_resep_roti;
                $newKasir->harga = (int) $request->harga;
                $newKasir->stok_masuk = $stokMasuk;
                $newKasir->stok_sekarang = $resep->stok_sekarang;
                $newKasir->laku =  $request->laku;
                $newKasir->roti_off = $request->roti_off;
                $newKasir->sisa_total = $sisa_total ;
                $newKasir->rizky = $pemesan == 'Rizky' ?  $request->input('laku') : 0;   // tambahkan kolom untuk Rizky
                $newKasir->palem = $pemesan == 'Palem' ?  $request->input('laku') : 0; // tambahkan kolom untuk Palem
                $newKasir->moro_jaya = $pemesan == 'Moro Jaya' ?  $request->input('laku') : 0; // tambahkan kolom untuk Moro Jaya
                $newKasir->total_rizky = $pemesan == 'Rizky' ? $harga_pemesan  * $request->laku : 0;
                $newKasir->total_palem = $pemesan == 'Palem' ? $harga_pemesan  * $request->laku : 0;
                $newKasir->total_moro_jaya =  $pemesan == 'Moro Jaya' ? $harga_pemesan * $request->laku : 0;
                $newKasir->total_penjualan_ini = $tpi;
                $newKasir->total_ppn = $request->laku * $ppn;
                $newKasir->tanggal_diproduksi  = $tanggal_sekarang;
                $newKasir->save();


                return redirect()->back()->with('success', 'Data kasir baru berhasil disimpan dari Pemesanan ' . $request->pemesanan . ' telah ditambahkan');
            }

            // END PEMESANAN


            // JIKA PEMBELIAN BIASA
            if ($resep->stok_sekarang  == 0 || $resep->stok_sekarang < $request->laku) {
                return redirect()->back()->with('warning', 'Stok roti tidak mencukupi pesanan');
            } else {


                $newKasir = new Kasir();
                $newKasir->nama_roti = $nama_resep_roti;
                $newKasir->harga = (int) $request->harga;
                $newKasir->stok_masuk = $stokMasuk;
                $newKasir->stok_sekarang = $resep->stok_sekarang;
                $newKasir->laku =  $request->laku;
                $newKasir->roti_off = $request->roti_off;
                $newKasir->sisa_total = $sisa_total;
                $newKasir->rizky = $pemesan == 'Rizky' ?  $request->input('laku') : 0;   // tambahkan kolom untuk Rizky
                $newKasir->palem = $pemesan == 'Palem' ?  $request->input('laku') : 0; // tambahkan kolom untuk Palem
                $newKasir->moro_jaya = $pemesan == 'Moro Jaya' ?  $request->input('laku') : 0; // tambahkan kolom untuk Moro Jaya
                $newKasir->total_rizky = $pemesan == 'Rizky' ? $result['harga_pemesan'] * $request->laku : 0;
                $newKasir->total_palem = $pemesan == 'Palem' ? $result['harga_pemesan'] * $request->laku : 0;
                $newKasir->total_moro_jaya =  $pemesan == 'Moro Jaya' ?  $result['harga_pemesan'] * $request->laku : 0;
                $newKasir->total_penjualan_ini = $tpi;
                $newKasir->total_ppn = $request->laku * $ppn;
                $newKasir->tanggal_diproduksi  = $tanggal_sekarang;
                $newKasir->save();

                if ($request->pemesanan == null) {
                    $resep->stok_sekarang = $request->input('sisa');
                    $resep->laku += $request->input('laku');
                    $resep->save();
                }

                return redirect()->back()->with('success', 'Data kasir baru berhasil disimpan.');
            }
            // END BUKAN PEMESANAN
        }
    }

    public function updateStokTersisa()
    {
        // Mendapatkan waktu sekarang dalam bentuk objek Carbon
        $carbon = new Carbon;

        // Mendapatkan data Kasir yang memiliki sisa_total lebih besar dari 0 dan tanggal_diproduksi sama dengan tanggal sekarang
        $kasir = Kasir::where('sisa_total', '>', 0)->whereDate('tanggal_diproduksi', '=', $carbon->now())->get();

        $besok = $carbon->now()->addDay(1)->format('Y-m-d');

        // Looping untuk setiap data Kasir yang ditemukan
        foreach ($kasir as $item) {
            // Membuat data baru berdasarkan data yang ada
            $newKasir = new Kasir();
            $newKasir->nama_roti = $item->nama_roti;
            $newKasir->harga = $item->harga;
            $newKasir->stok_masuk = $item->stok_masuk;
            $newKasir->stok_sekarang = $item->stok_sekarang;
            $newKasir->laku = $item->laku;
            $newKasir->sisa_total = $item->sisa_total;
            $newKasir->roti_off = 0;
            $newKasir->rizky = $item->rizky;
            $newKasir->palem = $item->palem;
            $newKasir->moro_jaya = $item->moro_jaya;
            $newKasir->total_rizky = $item->total_rizky;
            $newKasir->total_palem = $item->total_palem;
            $newKasir->total_moro_jaya = $item->total_moro_jaya;
            $newKasir->total_penjualan_ini = $item->total_penjualan_ini;
            $newKasir->total_ppn = $item->total_ppn;
            $newKasir->total_after_ppn = $item->total_after_ppn;
            $newKasir->tanggal_diproduksi = $besok; // Menambahkan 1 hari dari waktu sekarang untuk tanggal_diproduksi pada data baru
            // Menyimpan data baru ke dalam tabel Kasir
            $newKasir->save();

            // Update tanggal_diproduksi pada data Kasir yang ditemukan menjadi tanggal sekarang + 1 hari

        }

        Alert::success('Success', 'Data telah diperbarui');
        return redirect()->back();
    }

    public function hitungTotalPenjualan($request, $resep, $produksiRoti)
    {
        $pemesan = '';
        $harga_pemesan = $request->harga;
        $ppn = $resep->ppn;
        $laku = $request->laku;
        $tpi = 0;

        if ($request->pemesanan == 'Rizky' || $request->pemesanan == 'Palem' || $request->pemesanan == 'Moro Jaya') {
            $pemesan = $request->pemesanan;
            $harga_pemesan =  $request->harga + $ppn;
            $ppn = 0;
            $laku = $request->laku;
            $tpi = $harga_pemesan * $request->laku;
        }


        // Menyusun hasil perhitungan ke dalam array atau object, sesuai kebutuhan
        $result = [
            'pemesan' => $pemesan,
            'harga_pemesan' => $harga_pemesan,
            'ppn' => $ppn,
            'laku' => $laku,
            'tpi' => $tpi
        ];

        return $result;
    }

    public function setRotiOff($request,$resep)
    {
        $rotiOff = 0;


    }
}
