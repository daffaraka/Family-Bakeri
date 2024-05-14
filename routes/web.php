<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResepRotiController;
use App\Http\Controllers\KatalogRotiController;
use App\Http\Controllers\ProduksiRotiController;
use App\Http\Controllers\StokBahanBakuController;
use App\Http\Controllers\KeuanganHarianController;
use App\Http\Controllers\PaymentCallBackController;
use App\Http\Controllers\PemesananOnlineController;
use App\Http\Controllers\RealisasiProduksiController;
use App\Http\Controllers\PemesananBahanBakuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::get('tes', function () {
//     return view('tes');
// });

// Route::get('tes-data',[KasirController::class,'tes']);

Route::get('beranda', [FrontEndController::class, 'index'])->name('beranda.index');
Route::get('/', [FrontEndController::class, 'index'])->name('beranda');
Route::get('produk/{id}', [FrontEndController::class, 'produk'])->name('beranda.produk');

Route::middleware(['auth'])->group(function () {
    Route::get('produk/{id}/buat-pesanan', [FrontEndController::class, 'buatPesanan'])->name('beranda.buatPesanan');
    Route::post('produk/{id}/store-pesanan', [FrontEndController::class, 'storePesanan'])->name('beranda.storePesanan');
    Route::get('daftar-transaksi', [FrontEndController::class, 'daftarTransaksi'])->name('beranda.daftarTransaksi');
    Route::get('pembayaran/{id}', [FrontEndController::class, 'formBayar'])->name('beranda.formBayar');
    Route::get('pembayaran/{id}/bayar', [FrontEndController::class, 'bayar'])->name('beranda.bayar');
});

Route::post('cek-stok/{id}/produk',[FrontEndController::class,'cekStokProduk'])->name('cekStokProduk');


Route::get('beranda', [FrontEndController::class, 'index'])->name('beranda.index');
Route::middleware(['auth'])->group(function () {


    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pemesanan-bahan-baku', [PemesananBahanBakuController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan-bahan-baku/create', [PemesananBahanBakuController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan-bahan-baku/store', [PemesananBahanBakuController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan-bahan-baku/edit/{id}', [PemesananBahanBakuController::class, 'edit'])->name('pemesanan.edit');
    Route::post('/pemesanan-bahan-baku/update/{id}', [PemesananBahanBakuController::class, 'update'])->name('pemesanan.update');
    Route::get('/pemesanan-bahan-baku/delete/{id}', [PemesananBahanBakuController::class, 'delete'])->name('pemesanan.delete');

    Route::get('/stok-bahan-baku', [StokBahanBakuController::class, 'index'])->name('stok.index');
    Route::get('/stok-bahan-baku/create', [StokBahanBakuController::class, 'create'])->name('stok.create');
    Route::post('/stok-bahan-baku/store', [StokBahanBakuController::class, 'store'])->name('stok.store');
    Route::get('/stok-bahan-baku/edit/{id}', [StokBahanBakuController::class, 'edit'])->name('stok.edit');
    Route::post('/stok-bahan-baku/update/{id}', [StokBahanBakuController::class, 'update'])->name('stok.update');
    Route::get('/stok-bahan-baku/delete/{id}', [StokBahanBakuController::class, 'delete'])->name('stok.delete');

    Route::get('/produksi-roti', [ProduksiRotiController::class, 'index'])->name('produksi.index');
    Route::get('/produksi-roti/create', [ProduksiRotiController::class, 'create'])->name('produksi.create');

    Route::post('/produksi-roti/store', [ProduksiRotiController::class, 'store'])->name('produksi.store');
    Route::get('/produksi-roti/edit', [ProduksiRotiController::class, 'edit'])->name('produksi.edit');
    Route::get('/produksi-roti/detail/{id}', [ProduksiRotiController::class, 'show'])->name('produksi.detail');
    Route::get('/produksi-roti/detail/{id}/create-realisasi', [ProduksiRotiController::class, 'createRealisasi'])->name('produksi.createRealisasi');
    Route::post('/produksi-roti/update', [ProduksiRotiController::class, 'update'])->name('produksi.update');
    Route::get('/produksi-roti/delete/{id}', [ProduksiRotiController::class, 'delete'])->name('produksi.delete');
    Route::post('/produksi-roti/getDataResep/{id}', [ProduksiRotiController::class, 'getDataResep'])->name('produksi.getDataResep');

    Route::get('/realisasi-produksi', [RealisasiProduksiController::class, 'index'])->name('realisasi.index');
    Route::get('/realisasi-produksi/create', [RealisasiProduksiController::class, 'create'])->name('realisasi.create');
    Route::post('/realisasi-produksi/store', [RealisasiProduksiController::class, 'store'])->name('realisasi.store');
    Route::get('/realisasi-produksi/edit/{id}', [RealisasiProduksiController::class, 'edit'])->name('realisasi.edit');
    Route::post('/realisasi-produksi/update/{id}', [RealisasiProduksiController::class, 'update'])->name('realisasi.update');
    Route::get('/realisasi-produksi/delete/{id}', [RealisasiProduksiController::class, 'destroy'])->name('realisasi.delete');
    Route::post('/find-perencanaan-produksi/{id}', [RealisasiProduksiController::class, 'findPerencanaanProduksi'])->name('produksi.findPerencanaanProduksi');


    Route::get('/resep-roti', [ResepRotiController::class, 'index'])->name('resep.index');
    Route::get('/resep-roti/create', [ResepRotiController::class, 'create'])->name('resep.create');
    Route::post('/resep-roti/store', [ResepRotiController::class, 'store'])->name('resep.store');
    Route::get('/resep-roti/details/{id}', [ResepRotiController::class, 'show'])->name('resep.show');
    Route::get('/resep-roti/edit/{id}', [ResepRotiController::class, 'edit'])->name('resep.edit');
    Route::post('/resep-roti/update/{id}', [ResepRotiController::class, 'update'])->name('resep.update');
    Route::get('/resep-roti/delete/{id}', [ResepRotiController::class, 'delete'])->name('resep.delete');

    Route::get('/katalog-roti', [KatalogRotiController::class, 'index'])->name('katalog.index');
    Route::get('/katalog-roti/create', [KatalogRotiController::class, 'create'])->name('katalog.create');
    Route::post('/katalog-roti/store', [KatalogRotiController::class, 'store'])->name('katalog.store');
    Route::get('/katalog-roti/details/{id}', [KatalogRotiController::class, 'show'])->name('katalog.show');
    Route::get('/katalog-roti/edit/{id}', [KatalogRotiController::class, 'edit'])->name('katalog.edit');
    Route::post('/katalog-roti/update/{id}', [KatalogRotiController::class, 'update'])->name('katalog.update');
    Route::get('/katalog-roti/delete/{id}', [KatalogRotiController::class, 'destroy'])->name('katalog.delete');

    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::get('/kasir-customer', [KasirController::class, 'indexCustomer'])->name('kasir.indexCustomer');
    Route::get('/kasir-pemesanan', [KasirController::class, 'indexPemesanan'])->name('kasir.indexPemesanan');
    Route::get('/kasir/create', [KasirController::class, 'create'])->name('kasir.create');
    // Route::get('/kasir/create-customer', [KasirController::class, 'createCustomer'])->name('kasir.create-customer');
    // Route::get('/kasir/create-pemesanan', [KasirController::class, 'createPemesanan'])->name('kasir.create-pemesanan');

    Route::post('/kasir/store', [KasirController::class, 'store'])->name('kasir.store');
    Route::post('/kasir/store-customer', [KasirController::class, 'storeCustomer'])->name('kasir.storeCustomer');
    Route::post('/kasir/store-pemesanan', [KasirController::class, 'storePemesanan'])->name('kasir.storePemesanan');
    Route::get('/kasir/details/{id}', [KasirController::class, 'show'])->name('kasir.show');
    Route::get('/kasir/edit/{id}', [KasirController::class, 'edit'])->name('kasir.edit');
    Route::post('/kasir/update/{id}', [KasirController::class, 'update'])->name('kasir.update');
    Route::get('/kasir/delete/{id}', [KasirController::class, 'delete'])->name('kasir.delete');
    Route::get('/kasir/update-stok-tersisa', [KasirController::class, 'updateStokTersisa'])->name('kasir.updateStokTersisa');


    Route::resource('users', UserController::class);


    Route::get('/pemesanan-online', [PemesananOnlineController::class, 'index'])->name('pemesanan-online.index');
    Route::get('/pemesanan-online/{id}', [PemesananOnlineController::class, 'show'])->name('pemesanan-online.show');

    Route::resource('roles', RoleController::class);
    // Dropdown dinamis

    Route::resource('keuangan-harian', KeuanganHarianController::class, ['except' => ['destroy', 'update']]);
    Route::get('keuangan-harian/delete/{id}', [KeuanganHarianController::class, 'destroy'])->name('keuangan-harian.destroy');
    Route::post('keuangan-harian/update/{id}', [KeuanganHarianController::class, 'update'])->name('keuangan-harian.update');


    Route::post('/get-data-satuan/{id}', [ResepRotiController::class, 'getDataSatuan'])->name('getDataSatuan');
    Route::post('/get-data-roti/{id}', [KasirController::class, 'getDataRoti'])->name('getDataRoti');
    Route::get('/get-data-by-date/}', [KasirController::class, 'getDataByDate'])->name('getDataByDate');
});

// Route::get('select2-search-stok', [Select2Controller::class, 'searchStokBahanBaku']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('payment-callback',[PaymentCallBackController::class,'receive']);


require __DIR__ . '/auth.php';
