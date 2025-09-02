<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class DataTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = TransaksiNasabah::with(['satuan', 'nasabah', 'jenisSampah']); // tambahkan relasi

        // 🔹 filter nama nasabah
        if ($request->filled('nasabah')) {
            $baseQuery->whereHas('nasabah', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nasabah . '%');
            });
        }

        if ($request->filled('bulan')) {
            $baseQuery->whereMonth('tanggal_transaksi', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $baseQuery->whereYear('tanggal_transaksi', $request->tahun);
        }

        $data = (clone $baseQuery)
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10)
            ->appends($request->all());

        $totalPemasukan = (clone $baseQuery)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = (clone $baseQuery)->where('jenis', 'pengeluaran')->sum('jumlah');

        return view('pages.transaksi.list', compact('data', 'totalPemasukan', 'totalPengeluaran'));
    }

    public function export(Request $request)
    {
        $query = TransaksiNasabah::with(['satuan', 'nasabah', 'jenisSampah']);

        // 🔹 filter nama nasabah
        if ($request->filled('nasabah')) {
            $query->whereHas('nasabah', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nasabah . '%');
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_transaksi', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
        }

        $data = $query->orderBy('tanggal_transaksi', 'desc')->get();

        // ✅ Pakai PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Transaksi');

        // Header kolom
        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'Jenis');
        $sheet->setCellValue('C1', 'Nasabah');
        $sheet->setCellValue('D1', 'Jenis Sampah');
        $sheet->setCellValue('E1', 'Satuan');
        $sheet->setCellValue('F1', 'Jumlah');
        $sheet->setCellValue('G1', 'Uraian');

        // Isi data
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, Carbon::parse($item->tanggal_transaksi)->format('Y-m-d'));
            $sheet->setCellValue('B' . $row, $item->jenis);
            $sheet->setCellValue('C' . $row, $item->nasabah->nama ?? '-');
            $sheet->setCellValue('D' . $row, $item->jenisSampah->type_sampah ?? '-');
            $sheet->setCellValue('E' . $row, $item->satuan->satuan ?? '-');
            $sheet->setCellValue('F' . $row, $item->jumlah);
            $sheet->setCellValue('G' . $row, $item->uraian);
            $row++;
        }

        // ✅ Writer
        $writer = new Xlsx($spreadsheet);
        $filename = "data_transaksi.xlsx";

        // ✅ Stream download
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }
}
