<?php

namespace App\Http\Controllers;

use App\Models\MasterHargaSampah;
use App\Models\MasterJenisSampah;
use Illuminate\Http\Request;
use App\Models\TransaksiNasabah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeNasabahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $user = Auth::user();

        // Pastikan user punya nasabah_id
        if (!$user->nasabah_id) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar sebagai nasabah.');
        }

        // Ambil filter jenis sampah dari request
        $filterJenisSampah = $request->get('jenis_sampah');

        // Query dasar transaksi milik nasabah yang login
        $transaksiNasabah = TransaksiNasabah::where('master_nasabah_id', $user->nasabah_id)
            ->with(['jenisSampah', 'satuan', 'nasabah']);

        // Terapkan filter jenis sampah jika ada
        if ($filterJenisSampah) {
            $transaksiNasabah->where('master_jenis_sampah_id', $filterJenisSampah);
        }

        $transaksiNasabah = $transaksiNasabah->orderBy('tanggal_transaksi', 'desc');

        // Hitung statistik (gunakan query terpisah untuk data lengkap)
        $allTransaksiQuery = TransaksiNasabah::where('master_nasabah_id', $user->nasabah_id)
            ->with(['jenisSampah', 'satuan', 'nasabah']);

        $totalTransaksi = $allTransaksiQuery->count();

        // Transaksi bulan ini
        $transaksiBulanIni = $allTransaksiQuery->clone()
            ->whereMonth('tanggal_transaksi', Carbon::now()->month)
            ->whereYear('tanggal_transaksi', Carbon::now()->year)
            ->count();

        // Hitung total pemasukan dan pengeluaran dengan query yang lebih efisien
        $totalPemasukan = 0;
        $totalPengeluaran = 0;

        // Ambil semua transaksi dengan relasi harga untuk statistik umum
        $allTransaksi = $allTransaksiQuery->get();

        foreach ($allTransaksi as $transaksi) {
            $hargaSampah = MasterHargaSampah::where('id_master_jenis_sampah', $transaksi->master_jenis_sampah_id)->first();
            $nilaiTransaksi = $transaksi->jumlah_berat * ($hargaSampah->harga_sampah ?? 0);

            if ($transaksi->jenis == 'pemasukan') {
                $totalPemasukan += $nilaiTransaksi;
            } else {
                $totalPengeluaran += $nilaiTransaksi;
            }

            $transaksi->nilai_transaksi = $nilaiTransaksi;
            $transaksi->hargaSampah = $hargaSampah;
        }

        $saldo = $totalPengeluaran;

        $jenisTransaksi = TransaksiNasabah::where('master_nasabah_id', $user->nasabah_id)
            ->distinct('master_jenis_sampah_id')->count();

        $transaksiTerbaruQuery = TransaksiNasabah::where('master_nasabah_id', $user->nasabah_id)
            ->with(['jenisSampah', 'satuan', 'nasabah'])
            ->whereMonth('tanggal_transaksi', Carbon::now()->month)
            ->whereYear('tanggal_transaksi', Carbon::now()->year);

        if ($filterJenisSampah) {
            $transaksiTerbaruQuery->where('master_jenis_sampah_id', $filterJenisSampah);
        }

        $transaksiTerbaruData = $transaksiTerbaruQuery->orderBy('tanggal_transaksi', 'desc')
            ->take(10)
            ->get();

        // Tambahkan nilai transaksi untuk setiap transaksi terbaru
        foreach ($transaksiTerbaruData as $transaksi) {
            $hargaSampah = MasterHargaSampah::where('id_master_jenis_sampah', $transaksi->master_jenis_sampah_id)->first();
            $nilaiTransaksi = $transaksi->jumlah_berat * ($hargaSampah->harga_sampah ?? 0);
            $transaksi->nilai_transaksi = $nilaiTransaksi;
            $transaksi->hargaSampah = $hargaSampah;
        }

        // Ambil daftar jenis sampah untuk dropdown filter
        $jenisSampahList = MasterJenisSampah::whereIn(
            'id',
            TransaksiNasabah::where('master_nasabah_id', $user->nasabah_id)
                ->distinct()
                ->pluck('master_jenis_sampah_id')
        )->get();

        $chartData = $this->getChartData($user->nasabah_id);

        return view('dashboard.home', compact(
            'totalTransaksi',
            'transaksiBulanIni',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'jenisTransaksi',
            'transaksiTerbaruData',
            'chartData',
            'jenisSampahList',
            'filterJenisSampah'
        ));
    }

    private function getChartData($nasabahId)
    {
        $weeks = 4; // Menampilkan 4 minggu terakhir
        $dates = collect();
        $pemasukan = collect();
        $pengeluaran = collect();

        for ($i = $weeks - 1; $i >= 0; $i--) {
            // Hitung minggu ke-i dari sekarang
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();

            // Format label untuk minggu (contoh: "W1 Jan", "W2 Jan", dll)
            $weekNumber = $startOfWeek->weekOfMonth;
            $monthName = $startOfWeek->format('M');
            $dates->push("W{$weekNumber} {$monthName}");

            // Ambil semua transaksi dalam rentang minggu ini
            $weeklyTransactions = TransaksiNasabah::where('master_nasabah_id', $nasabahId)
                ->whereBetween('tanggal_transaksi', [
                    $startOfWeek->format('Y-m-d 00:00:00'),
                    $endOfWeek->format('Y-m-d 23:59:59')
                ])
                ->with('jenisSampah')
                ->get();

            $weeklyPemasukan = 0;
            $weeklyPengeluaran = 0;

            foreach ($weeklyTransactions as $transaction) {
                // Ambil harga sampah berdasarkan jenis sampah
                $hargaSampah = MasterHargaSampah::where('id_master_jenis_sampah', $transaction->master_jenis_sampah_id)->first();
                $nilaiTransaksi = $transaction->jumlah_berat * ($hargaSampah->harga_sampah ?? 0);

                if ($transaction->jenis == 'pemasukan') {
                    $weeklyPemasukan += $nilaiTransaksi;
                } else {
                    $weeklyPengeluaran += $nilaiTransaksi;
                }
            }

            $pemasukan->push($weeklyPemasukan);
            $pengeluaran->push($weeklyPengeluaran);
        }

        return [
            'labels' => $dates->toArray(),
            'pemasukan' => $pengeluaran->toArray() // Ditambahkan untuk kelengkapan data
        ];
    }

}
