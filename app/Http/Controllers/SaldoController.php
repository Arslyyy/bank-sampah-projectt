<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiNasabah;
use App\Models\MasterNasabah;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaldoController extends Controller
{
    public function index()
    {
        $tahun = Carbon::now()->year;

        // ambil saldo akhir per bulan
        $saldoPerBulan = TransaksiNasabah::select(
                DB::raw('MONTH(tanggal_transaksi) as bulan'),
                DB::raw("SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) -
                         SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END) -
                         SUM(CASE WHEN jenis = 'operasional' THEN jumlah ELSE 0 END) as saldo_akhir")
            )
            ->whereYear('tanggal_transaksi', $tahun)
            ->groupBy(DB::raw('MONTH(tanggal_transaksi)'))
            ->orderBy(DB::raw('MONTH(tanggal_transaksi)'))
            ->get();

        // siapkan label bulan dan data saldo
        $labels = [];
        $data = [];

        foreach ($saldoPerBulan as $item) {
            $labels[] = Carbon::create()->month($item->bulan)->translatedFormat('F'); // nama bulan
            $data[] = (int) $item->saldo_akhir;
        }

        // total keseluruhan untuk card
        $totalPemasukan = TransaksiNasabah::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = TransaksiNasabah::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalOperasional = TransaksiNasabah::where('jenis', 'operasional')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran - $totalOperasional;

        // ambil Top 10 Nasabah (nama dan total nominal transaksi)
        $topNasabah = TransaksiNasabah::select('master_nasabah.nama', DB::raw('SUM(transaksi_nasabah.jumlah) as nominal'))
            ->join('master_nasabah', 'transaksi_nasabah.master_nasabah_id', '=', 'master_nasabah.id')
            ->groupBy('master_nasabah.nama')
            ->orderByDesc('nominal')
            ->limit(10)
            ->get();

        return view('pages.saldo.list', compact(
            'labels',
            'data',
            'totalPemasukan',
            'totalPengeluaran',
            'totalOperasional',
            'saldoAkhir',
            'topNasabah'
        ));
    }
}
