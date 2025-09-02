<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiNasabah;

class DashboardNasabahController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nasabah_id dari user yang login
        $nasabah_id = Auth::user()->nasabah_id;

        // Query transaksi pengeluaran milik nasabah ini
        $query = TransaksiNasabah::with(['nasabah', 'jenisSampah', 'satuan'])
                    ->where('jenis', 'pengeluaran')
                    ->where('master_nasabah_id', $nasabah_id);

        // Filter bulan & tahun
        if ($request->bulan) {
            $query->whereMonth('tanggal_transaksi', $request->bulan);
        }
        if ($request->tahun) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
        }

        $data = $query->orderBy('tanggal_transaksi', 'desc')->paginate(10);

        return view('pages.transaksi.pengeluaran.listnasabah', compact('data'));
    }
}
