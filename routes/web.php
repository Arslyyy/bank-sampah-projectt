<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterHargaSampahController;
use App\Http\Controllers\MasterJenisSampahController;
use App\Http\Controllers\MasterNasabahController;
use App\Http\Controllers\MasterSatuanController;
use App\Http\Controllers\TransaksiNasabahController;
use App\Http\Controllers\ProfileController;
use App\Models\MasterJenisSampah;
use App\Models\MasterNasabah;
use App\Models\MasterSatuan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengeluaranNasabahController;
use App\Http\Controllers\PemasukkanController;
use App\Http\Controllers\DataTransaksiController;

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



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('manajemen/nasabah', [MasterNasabahController::class, 'index'])->name('nasabah.index');
    Route::get('manajemen/nasabah/create', [MasterNasabahController::class, 'create'])->name('nasabah.create');
    Route::post('manajemen/nasabah/store', [MasterNasabahController::class, 'store'])->name('nasabah.store');
    Route::get('manajemen/nasabah/edit/{id}', [MasterNasabahController::class, 'edit'])->name('nasabah.edit')->where('id', '[0-9]+');
    Route::put('manajemen/nasabah/update/{id}', [MasterNasabahController::class, 'update'])->name('nasabah.update')->where('id', '[0-9]+');

    // Route::get('transaksi/data-transaksi', [TransaksiNasabahController::class, 'index'])->name('transaksi.index');
    // Route::get('transaksi/data-transaksi/create', [TransaksiNasabahController::class, 'create'])->name('transaksi.create');
    // Route::post('transaksi/data-transaksi/store', [TransaksiNasabahController::class, 'store'])->name('transaksi.store');
    // Route::get('transaksi/data-transaksi/edit/{id}', [TransaksiNasabahController::class, 'edit'])->name('transaksi.edit')->where('id', '[0-9]+');
    // Route::put('transaksi/data-transaksi/update/{id}', [TransaksiNasabahController::class, 'update'])->name('transaksi.update')->where('id', '[0-9]+');
    // Route::get('transaksi/data-transaksi/delete/{id}', [TransaksiNasabahController::class, 'destroy'])->name('transaksi.destroy')->where('id', '[0-9]+');

    Route::get('transaksi/pemasukkan', [PemasukkanController::class, 'index'])->name('pemasukkan.index');
    Route::get('transaksi/pemasukkan/create', [PemasukkanController::class, 'create'])->name('pemasukkan.create');
    Route::post('transaksi/pemasukkan/store', [PemasukkanController::class, 'store'])->name('pemasukkan.store');
    Route::get('transaksi/pemasukkan/edit/{id}', [PemasukkanController::class, 'edit'])->name('pemasukkan.edit')->where('id', '[0-9]+');
    Route::put('transaksi/pemasukkan/update/{id}', [PemasukkanController::class, 'update'])->name('pemasukkan.update')->where('id', '[0-9]+');
    Route::get('transaksi/pemasukkan/delete/{id}', [PemasukkanController::class, 'destroy'])->name('pemasukkan.destroy')->where('id', '[0-9]+');

    Route::get('transaksi/pengeluaran', [PengeluaranNasabahController::class, 'index'])->name('pengeluaran.index');
    Route::get('transaksi/pengeluaran/create', [PengeluaranNasabahController::class, 'create'])->name('pengeluaran.create');
    Route::post('transaksi/pengeluaran/store', [PengeluaranNasabahController::class, 'store'])->name('pengeluaran.store');
    Route::get('transaksi/pengeluaran/edit/{id}', [PengeluaranNasabahController::class, 'edit'])->name('pengeluaran.edit')->where('id', '[0-9]+');
    Route::put('transaksi/pengeluaran/update/{id}', [PengeluaranNasabahController::class, 'update'])->name('pengeluaran.update')->where('id', '[0-9]+');
    Route::get('transaksi/pengeluaran/delete/{id}', [PengeluaranNasabahController::class, 'destroy'])->name('pengeluaran.destroy')->where('id', '[0-9]+');


    Route::get('bank/satuan', [MasterSatuanController::class, 'index'])->name('satuan.index');
    Route::get('bank/satuan/create', [MasterSatuanController::class, 'create'])->name('satuan.create');
    Route::post('bank/satuan/store', [MasterSatuanController::class, 'store'])->name('satuan.store');
    Route::get('bank/satuan/edit/{id}', [MasterSatuanController::class, 'edit'])->name('satuan.edit')->where('id', '[0-9]+');
    Route::put('bank/satuan/update/{id}', [MasterSatuanController::class, 'update'])->name('satuan.update')->where('id', '[0-9]+');
    Route::delete('bank/satuan/delete/{id}', [MasterSatuanController::class, 'destroy']);

    Route::get('bank/jenis', [MasterJenisSampahController::class, 'index'])->name('jenis.index');
    Route::get('bank/jenis/create', [MasterJenisSampahController::class, 'create'])->name('jenis.create');
    Route::post('bank/jenis/store', [MasterJenisSampahController::class, 'store'])->name('jenis.store');
    Route::get('bank/jenis/edit/{id}', [MasterJenisSampahController::class, 'edit'])->name('jenis.edit')->where('id', '[0-9]+');
    Route::put('bank/jenis/update/{id}', [MasterJenisSampahController::class, 'update'])->name('jenis.update')->where('id', '[0-9]+');
    Route::delete('bank/jenis/delete/{id}', [MasterJenisSampahController::class, 'destroy']);

    Route::get('bank/harga', [MasterHargaSampahController::class, 'index'])->name('harga.index');
    Route::get('bank/harga/create', [MasterHargaSampahController::class, 'create'])->name('harga.create');
    Route::post('bank/harga/store', [MasterHargaSampahController::class, 'store'])->name('harga.store');
    Route::get('bank/harga/edit/{id}', [MasterHargaSampahController::class, 'edit'])->name('harga.edit')->where('id', '[0-9]+');
    Route::put('bank/harga/update/{id}', [MasterHargaSampahController::class, 'update'])->name('harga.update')->where('id', '[0-9]+');

    Route::get('transaksi/data', [\App\Http\Controllers\DataTransaksiController::class, 'index'])->name('transaksi.index');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



require __DIR__ . '/auth.php';
