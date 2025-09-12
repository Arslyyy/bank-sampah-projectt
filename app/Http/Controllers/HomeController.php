<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
public function index()
{
    // ambil transaksi beserta relasi jenisSampah
    $datas = TransaksiNasabah::with('jenisSampah')->get();

    // ambil daftar jenis sampah unik dari transaksi yang sudah ada
    $jenisList = $datas->pluck('jenisSampah.type_sampah')->filter()->unique();

    return view('pages.transaksi.list_home', compact('datas', 'jenisList'));
}

}
