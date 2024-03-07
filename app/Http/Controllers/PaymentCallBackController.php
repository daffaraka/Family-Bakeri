<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kasir;
use App\Models\Order;
use App\Models\ResepRoti;
use App\Models\KatalogRoti;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\KasirController;
use App\Services\Midtrans\CallbackService;

class PaymentCallBackController extends Controller
{

    public function receive()
    {
        $callback = new CallbackService();

        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order =  $callback->getOrder();
            // $orderData = [
            //     'id' => $order->id,
            //     'nama_pemesan' => $order->customer->name,
            //     'deskripsi_pesanan' => $order->deskripsi_pesanan,
            //     'order_id' => $order->order_id,
            //     'kontak_pemesan' => $order->customer->email,
            //     'tanggal_diambil' => $order->tanggal_diambil,
            //     'qty' => $order->qty,
            //     'payment_status' => $order->payment_status,
            //     'snap_token' => $order->snap_token,
            //     'total' => $order->total,
            //     'user_id' => $order->user_id,
            //     'katalog_id' => $order->katalog_id,
            //     'katalog' => [
            //         'id' => $order->katalog->id,
            //         'resep_roti_id' => $order->katalog->resep_roti_id,
            //         'stok' => $order->katalog->stok,
            //         'laku' => $order->katalog->laku,
            //         'deskripsi' => $order->katalog->deskripsi,
            //         'resep_roti' => [
            //             'id' => $order->katalog->resepRoti->id,
            //             'nama_resep_roti' => $order->katalog->resepRoti->nama_resep_roti,
            //             'harga' => $order->katalog->resepRoti->harga,
            //             'ppn' => $order->katalog->resepRoti->ppn,
            //             'gambar_roti' => $order->katalog->resepRoti->gambar_roti,
            //         ],
            //     ],
            //     'customer' => [
            //         'id' => $order->customer->id,
            //         'name' => $order->customer->name,
            //         'email' => $order->customer->email,
            //         'email_verified_at' => $order->customer->email_verified_at,
            //     ],
            // ];


            // dd($order);
            // $kasirController->storeCustomer(new Request($order));
            $this->addDataKasirCustomer($order);


            // if ($callback->isPending()) {
            //     Order::where('id', $order->id)->update([
            //         'payment_status' => 1,
            //     ]);
            // }

            // if ($callback->isSuccess()) {


            //     $order->katalog->stok -= $order->qty;
            //     $order->katalog->save();

            //     Order::where('id', $order->id)->update([
            //         'payment_status' => 2,
            //     ]);

            //     $orderData = [
            //         'id' => $order->id,
            //         'nama_pemesan' => $order->customer->name,
            //         'deskripsi_pesanan' => $order->deskripsi_pesanan,
            //         'order_id' => $order->order_id,
            //         'kontak_pemesan' => $order->customer->email,
            //         'tanggal_diambil' => $order->tanggal_diambil,
            //         'qty' => $order->qty,
            //         'payment_status' => $order->payment_status,
            //         'snap_token' => $order->snap_token,
            //         'total' => $order->total,
            //         'user_id' => $order->user_id,
            //         'katalog_id' => $order->katalog_id,
            //         'katalog' => [
            //             'id' => $order->katalog->id,
            //             'resep_roti_id' => $order->katalog->resep_roti_id,
            //             'stok' => $order->katalog->stok,
            //             'laku' => $order->katalog->laku,
            //             'deskripsi' => $order->katalog->deskripsi,
            //             'resep_roti' => [
            //                 'id' => $order->katalog->resepRoti->id,
            //                 'nama_resep_roti' => $order->katalog->resepRoti->nama_resep_roti,
            //                 'harga' => $order->katalog->resepRoti->harga,
            //                 'ppn' => $order->katalog->resepRoti->ppn,
            //                 'gambar_roti' => $order->katalog->resepRoti->gambar_roti,
            //             ],
            //         ],
            //         'customer' => [
            //             'id' => $order->customer->id,
            //             'name' => $order->customer->name,
            //             'email' => $order->customer->email,
            //             'email_verified_at' => $order->customer->email_verified_at,
            //         ],
            //     ];

            //     $kasirController = new KasirController();
            //     $kasirController->storeCustomer(new Request($orderData));
            // }

            // if ($callback->isExpire()) {
            //     Order::where('id', $order->id)->update([
            //         'payment_status' => 3,
            //     ]);
            // }

            // if ($callback->isCancelled()) {
            //     Order::where('id', $order->id)->update([
            //         'payment_status' => 4,
            //     ]);
            // }

            // return response()
            // ->json([
            //     // 'katalog' => $order->katalog->resepRoti,
            //     'success' => true,
            //     'message' => 'Notification successfully processed',
            //     'order' => $order,

            // ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key not verified',
                ], 403);
        }
    }


    public function addDataKasirCustomer($order)
    {

        $kasir = Kasir::where('nama_roti', $order->katalog->resepRoti->nama_resep_roti)->first();
        // Nama Resep
        $nama_resep_roti = $order->katalog->resepRoti->nama_resep_roti;

        $resep = ResepRoti::with(['bahanBaku', 'katalogRoti'])->where('nama_resep_roti', $order->katalog->resepRoti->nama_resep_roti)->first();
        // Inisiasi harga
        $harga = $order->harga;

        $stokMasuk = $resep->katalogRoti->stok;

        // Inisiasi pemesan
        // Inisiasi Sisa
        $sisa_total = $resep->katalogRoti->stok - $order->laku;

        // Inisiasi PPN
        $ppn = $resep->ppn;
        $tanggal_sekarang = Carbon::now()->format('Y-m-d');

        // Inisiasi Total Penjualan Ini

        $tpi = ($order->harga * $order->laku) + ($ppn * $order->laku);

        $laku = $order->laku;



        // $kasir untuk memeriksa jika ada roti pada data kasir hari ini
        if ($kasir) {
            if ($resep->katalogRoti->stok  == 0 || $resep->katalogRoti->stok < $order->laku) {
                return redirect()->back()->with('warning', 'Stok roti tidak mencukupi pesanan');
            } else {
                // dd('Ini biasa');
                $kasir->nama_roti = $nama_resep_roti;
                $kasir->stok_masuk = $stokMasuk;
                $kasir->stok_sekarang = $resep->katalogRoti->stok;
                $kasir->laku = $kasir->laku += $laku;
                $kasir->roti_off = $order->roti_off ?? 0;
                $kasir->sisa_total = $order->sisa;
                $kasir->total_penjualan_ini = $kasir->total_penjualan_ini += $tpi;
                $kasir->total_ppn += $order->laku * $ppn;
                $kasir->tanggal_diproduksi  = $tanggal_sekarang;
                $kasir->save();

                if ($order->pemesanan == null) {
                    $resep->katalogRoti->stok = $order->input('sisa');
                    $resep->katalogRoti->laku += $order->input('laku');
                    $resep->katalogRoti->save();
                }
            }
        }
        // Ini jika kosong
        else {
            if ($resep->katalogRoti->stok  == 0 || $resep->katalogRoti->stok < $order->laku) {
                return redirect()->back()->with('warning', 'Stok roti tidak mencukupi pesanan');
            } else {

                $newKasir = new Kasir();
                $newKasir->nama_roti = $nama_resep_roti;
                $newKasir->harga = (int) $order->harga;
                $newKasir->stok_masuk = $stokMasuk;
                $newKasir->stok_sekarang = $resep->katalogRoti->stok;
                $newKasir->laku =  $order->laku;
                $newKasir->roti_off = $order->roti_off ?? 0;
                $newKasir->sisa_total = $sisa_total;
                $newKasir->total_penjualan_ini = $tpi;
                $newKasir->total_ppn = $order->laku * $ppn;
                $newKasir->tanggal_diproduksi  = $tanggal_sekarang;
                $newKasir->save();

                if ($order->pemesanan == null) {
                    $resep->katalogRoti->stok = $order->input('sisa');
                    $resep->katalogRoti->laku += $order->input('laku');
                    $resep->katalogRoti->save();
                }

            }
        }
    }
}
