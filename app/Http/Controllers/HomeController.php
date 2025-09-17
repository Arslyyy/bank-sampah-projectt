<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use App\Models\MasterNasabah;
use App\Models\MasterJenisSampah;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

public function index()
{
    // ambil data transaksi + relasi
    $datas = TransaksiNasabah::with(['nasabah', 'jenisSampah'])->get();

    // ambil total dari tabel master
    $totalNasabah = MasterNasabah::count();
    $totalJenisSampah = MasterJenisSampah::count();

    // ambil daftar jenis sampah
    $jenisList = MasterJenisSampah::pluck('type_sampah');

    return view('pages.transaksi.list_home', compact(
        'datas',
        'totalNasabah',
        'totalJenisSampah',
        'jenisList'
    ));
}

}
