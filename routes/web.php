<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeNasabahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasterNasabahController;
use App\Http\Controllers\PemasukkanController;
use App\Http\Controllers\PengeluaranNasabahController;
use App\Http\Controllers\MasterSatuanController;
use App\Http\Controllers\MasterJenisSampahController;
use App\Http\Controllers\MasterHargaSampahController;
use App\Http\Controllers\DataTransaksiController;
use App\Http\Controllers\DashboardNasabahController;
use Illuminate\Support\Facades\Route;

// Default route → redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// ====================
// ADMIN ROUTES
// ====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    // Profile Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Manajemen Nasabah
    Route::prefix('manajemen/nasabah')->group(function () {
        Route::get('/', [MasterNasabahController::class, 'index'])->name('nasabah.index');
        Route::get('/create', [MasterNasabahController::class, 'create'])->name('nasabah.create');
        Route::post('/store', [MasterNasabahController::class, 'store'])->name('nasabah.store');
        Route::get('/edit/{id}', [MasterNasabahController::class, 'edit'])->name('nasabah.edit')->where('id', '[0-9]+');
        Route::put('/update/{id}', [MasterNasabahController::class, 'update'])->name('nasabah.update')->where('id', '[0-9]+');
        Route::delete('/{id}', [MasterNasabahController::class, 'destroy'])->name('nasabah.destroy');
    });

    // Transaksi Pemasukkan
    Route::prefix('transaksi/pemasukkan')->group(function () {
        Route::get('/', [PemasukkanController::class, 'index'])->name('pemasukkan.index');
        Route::get('/create', [PemasukkanController::class, 'create'])->name('pemasukkan.create');
        Route::post('/store', [PemasukkanController::class, 'store'])->name('pemasukkan.store');
        Route::get('/edit/{id}', [PemasukkanController::class, 'edit'])->name('pemasukkan.edit')->where('id', '[0-9]+');
        Route::put('/update/{id}', [PemasukkanController::class, 'update'])->name('pemasukkan.update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', [PemasukkanController::class, 'destroy'])->name('pemasukkan.destroy')->where('id', '[0-9]+');
    });

    // Transaksi Pengeluaran
    Route::prefix('transaksi/pengeluaran')->group(function () {
        Route::get('/', [PengeluaranNasabahController::class, 'index'])->name('pengeluaran.index');
        Route::get('/create', [PengeluaranNasabahController::class, 'create'])->name('pengeluaran.create');
        Route::post('/store', [PengeluaranNasabahController::class, 'store'])->name('pengeluaran.store');
        Route::get('/edit/{id}', [PengeluaranNasabahController::class, 'edit'])->name('pengeluaran.edit')->where('id', '[0-9]+');
        Route::put('/update/{id}', [PengeluaranNasabahController::class, 'update'])->name('pengeluaran.update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', [PengeluaranNasabahController::class, 'destroy'])->name('pengeluaran.destroy')->where('id', '[0-9]+');
    });

    // Master Data
    Route::prefix('bank/satuan')->group(function () {
        Route::get('/', [MasterSatuanController::class, 'index'])->name('satuan.index');
        Route::get('/create', [MasterSatuanController::class, 'create'])->name('satuan.create');
        Route::post('/store', [MasterSatuanController::class, 'store'])->name('satuan.store');
        Route::get('/edit/{id}', [MasterSatuanController::class, 'edit'])->name('satuan.edit')->where('id', '[0-9]+');
        Route::put('/update/{id}', [MasterSatuanController::class, 'update'])->name('satuan.update')->where('id', '[0-9]+');
        Route::delete('/{id}', [MasterSatuanController::class, 'destroy'])->name('satuan.destroy');
    });

    Route::prefix('bank/jenis')->group(function () {
        Route::get('/', [MasterJenisSampahController::class, 'index'])->name('jenis.index');
        Route::get('/create', [MasterJenisSampahController::class, 'create'])->name('jenis.create');
        Route::post('/store', [MasterJenisSampahController::class, 'store'])->name('jenis.store');
        Route::get('/edit/{id}', [MasterJenisSampahController::class, 'edit'])->name('jenis.edit')->where('id', '[0-9]+');
        Route::put('/update/{id}', [MasterJenisSampahController::class, 'update'])->name('jenis.update')->where('id', '[0-9]+');
        Route::delete('/delete/{id}', [MasterJenisSampahController::class, 'destroy']);
    });

    Route::prefix('bank/harga')->group(function () {
        Route::get('/', [MasterHargaSampahController::class, 'index'])->name('harga.index');
        Route::get('/create', [MasterHargaSampahController::class, 'create'])->name('harga.create');
        Route::post('/store', [MasterHargaSampahController::class, 'store'])->name('harga.store');
        Route::get('/edit/{id}', [MasterHargaSampahController::class, 'edit'])->name('harga.edit')->where('id', '[0-9]+');
        Route::put('/update/{id}', [MasterHargaSampahController::class, 'update'])->name('harga.update')->where('id', '[0-9]+');
    });

    // Data Transaksi
    Route::get('transaksi/data', [DataTransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/export', [DataTransaksiController::class, 'export'])->name('transaksi.export');
});

// ====================
// NASABAH ROUTES
// ====================
Route::middleware(['auth', 'role:nasabah'])->prefix('nasabah')->group(function () {
    Route::get('/dashboard', [HomeNasabahController::class, 'index'])->name('nasabah.dashboard');
});
Route::middleware(['auth', 'role:nasabah'])->prefix('nasabah')->group(function () {
Route::get('/dashboard', [DashboardNasabahController::class, 'index'])->name('nasabah.dashboard');

// Transaksi pengeluaran milik nasabah
Route::get('/pengeluaran', [DashboardNasabahController::class, 'pengeluaran'])->name('nasabah.pengeluaran.index');
});


// ambil harga
Route::get('/get-harga/{id}', [PengeluaranNasabahController::class, 'getHarga']);



require __DIR__ . '/auth.php';
