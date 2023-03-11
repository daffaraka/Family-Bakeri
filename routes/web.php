<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PemesananBahanBakuController;
use App\Http\Controllers\StokBahanBakuController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/pemesanan-bahan-baku',[PemesananBahanBakuController::class,'index'])->name('pemesanan.index');
Route::get('/pemesanan-bahan-baku/create',[PemesananBahanBakuController::class,'create'])->name('pemesanan.create');
Route::post('/pemesanan-bahan-baku/store',[PemesananBahanBakuController::class,'store'])->name('pemesanan.store');
Route::get('/pemesanan-bahan-baku/edit/{id}',[PemesananBahanBakuController::class,'edit'])->name('pemesanan.edit');
Route::post('/pemesanan-bahan-baku/update/{id}',[PemesananBahanBakuController::class,'update'])->name('pemesanan.update');
Route::get('/pemesanan-bahan-baku/delete/{id}',[PemesananBahanBakuController::class,'delete'])->name('pemesanan.delete');

Route::get('/stok-bahan-baku',[StokBahanBakuController::class,'index'])->name('stok.index');
Route::get('/stok-bahan-baku/create',[StokBahanBakuController::class,'create'])->name('stok.create');
Route::post('/stok-bahan-baku/store',[StokBahanBakuController::class,'store'])->name('stok.store');
Route::get('/stok-bahan-baku/edit/{id}',[StokBahanBakuController::class,'edit'])->name('stok.edit');
Route::post('/stok-bahan-baku/update/{id}',[StokBahanBakuController::class,'update'])->name('stok.update');
Route::get('/stok-bahan-baku/delete/{id}',[StokBahanBakuController::class,'delete'])->name('stok.delete');


Route::get('/produksi-roti',[StokBahanBakuController::class,'index'])->name('produksi.index');
Route::get('/produksi-roti/create',[StokBahanBakuController::class,'create'])->name('produksi.create');
Route::post('/produksi-roti/store',[StokBahanBakuController::class,'store'])->name('produksi.store');
Route::get('/produksi-roti/edit/{id}',[StokBahanBakuController::class,'edit'])->name('produksi.edit');
Route::post('/produksi-roti/update/{id}',[StokBahanBakuController::class,'update'])->name('produksi.update');
Route::get('/produksi-roti/delete/{id}',[StokBahanBakuController::class,'delete'])->name('produksi.delete');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
