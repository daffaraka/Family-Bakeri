<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ResepRoti;
use App\Models\KatalogRoti;
use Illuminate\Http\Request;
use App\Models\PemesananOnline;
use Illuminate\Support\Facades\Auth;
use App\Services\Midtrans\CreateSnapTokenService;
use Midtrans\Snap;

use App\Services\Midtrans\Midtrans;
use Midtrans\Config;

class FrontEndController extends Controller
{

    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;


    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized');
        $this->is3ds = config('midtrans.is_3ds');

        $this->_configureMidtrans();
    }

    public function _configureMidtrans()
    {
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }


    public function index()
    {
        $data = KatalogRoti::with('resepRoti')->get();

        return view('front-end.beranda', compact('data'));
    }

    public function produk($id)
    {
        $data = KatalogRoti::with('resepRoti')->find($id);

        return view('front-end.detail-produk', compact('data'));
    }

    public function buatPesanan($id)
    {
        $data = KatalogRoti::with('resepRoti')->find($id);

        return view('front-end.buat-pesanan', compact('data'));
    }

    public function storePesanan(Request $request, $id)
    {

        // dd($request->all());
        $katalog = KatalogRoti::with('ResepRoti')->find($id);
        $harga = $katalog->harga;
        $total = $request->jumlah_pesanan * $katalog->ResepRoti->harga;

        // dd($total);
        $order = new Order;
        $order->nama_pemesan = $request->nama_pemesan;
        $order->deskripsi_pesanan = $request->deskripsi_pesanan;
        $order->kontak_pemesan = $request->kontak_pemesan;
        $order->tanggal_diambil = $request->tanggal_diambil;
        $order->total = $total;
        $order->qty = $request->jumlah_pesanan;
        $order->katalog_id = $katalog->id;
        $order->user_id = Auth::user()->id;


        $order->save();



        return redirect()->route('beranda.daftarTransaksi');
    }


    public function daftarTransaksi()
    {
        $user_id = Auth::user()->id;
        $data['orders'] = Order::with('katalog.resepRoti')->where('user_id', $user_id)->latest()->get();
        // dd($data);

        return view('front-end.daftar-transaksi', $data);
    }


    public function formBayar($id)
    {
        $order = Order::with('katalog.resepRoti')->find($id);


        $relatedProducts = KatalogRoti::with('resepRoti')->where('id','!=' , $order->katalog_id)->get();

        // dd($relatedProducts);
        $snapToken = '';
        $payload = [
            'transaction_details' => [
                'order_id'     => $order->order_id,
                'gross_amount' => $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->nama_pemesan,
                'phone' => $order->kontak_pemesan,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id'            => $order->katalog_id,
                    'price'         =>  $order->katalog->resepRoti->harga,
                    'quantity'      => $order->qty,
                    'name'          => 'Pemesanan ' . $order->katalog->resepRoti->nama_resep_roti,
                    'brand'         => 'Family Bakery',
                    'merchant_name' => config('app.name'),
                ],
            ],
        ];


        // dd($order->order_id);
        if (empty($order->snap_token)) {
            $order->snap_token = Snap::getSnapToken($payload);
            $order->save();
        }



        $snapToken = $order->snap_token;
        return view('front-end.bayar', compact('order', 'snapToken', 'relatedProducts'));
    }

    public function bayar($id)
    {

        $order = Order::with('katalog')->find($id);
    }



    public function cekStokProduk($id)
    {
        $katalog = KatalogRoti::with('resepRoti')->find($id);
        $stokProduk = $katalog->stok;



        return response()->json([
            'stok' => $stokProduk,
            'Jumlah Stok Tersedia' =>$stokProduk,
            'Nama Produk ' => $katalog->resepRoti->nama_resep_roti,
            'Laku' => $katalog->laku
        ]);

    }
}
