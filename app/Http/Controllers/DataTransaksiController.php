<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use Illuminate\Http\Request;

class DataTransaksiController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi, urutkan dari terbaru
        $data = TransaksiNasabah::with(['satuan'])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        return view('pages.transaksi.list', compact('data'));
    }
}
