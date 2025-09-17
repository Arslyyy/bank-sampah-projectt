<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DataTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = TransaksiNasabah::with(['satuan', 'nasabah', 'jenisSampah']);

        // 🔹 Filter nama nasabah
        if ($request->filled('nasabah')) {
            $baseQuery->whereHas('nasabah', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nasabah . '%');
            });
        }

        // 🔹 Filter bulan & tahun
        if ($request->filled('bulan')) {
            $baseQuery->whereMonth('tanggal_transaksi', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $baseQuery->whereYear('tanggal_transaksi', $request->tahun);
        }

        // 🔹 Data tabel
        $data = (clone $baseQuery)
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10)
            ->appends($request->all());

        // 🔹 Total transaksi
        $totalPemasukan = (clone $baseQuery)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = (clone $baseQuery)->where('jenis', 'pengeluaran')->sum('jumlah');
        $totalOperasional = (clone $baseQuery)->where('jenis', 'operasional')->sum('jumlah');

        // 🔹 Sisa saldo
        $sisaSaldo = $totalPemasukan - $totalPengeluaran - $totalOperasional;

        return view('pages.transaksi.list', compact(
            'data',
            'totalPemasukan',
            'totalPengeluaran',
            'totalOperasional',
            'sisaSaldo'
        ));
    }

    public function export(Request $request)
    {
        $query = TransaksiNasabah::query();

        if ($request->filled('nasabah')) {
            $query->whereHas('nasabah', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nasabah . '%');
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_transaksi', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
        }

        $data = $query->orderBy('tanggal_transaksi', 'asc')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Buku Kas');

        // Judul
        $sheet->setCellValue('A1', 'BUKU KAS BANK SAMPAH "SALAM LESTARI" RW 05');
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A2', 'Kel. KEMBANGSARI, KEC. SEMARANG TENGAH, SEMARANG');
        $sheet->mergeCells('A2:F2');

        $bulanNama = \Carbon\Carbon::createFromDate($request->tahun, $request->bulan, 1)
            ->translatedFormat('F Y');
        $sheet->setCellValue('A4', "BULAN : " . $bulanNama);
        $sheet->mergeCells('A4:F4');

        // Header tabel
        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Tanggal');
        $sheet->setCellValue('C6', 'Uraian');
        $sheet->setCellValue('D6', 'Masuk');
        $sheet->setCellValue('E6', 'Keluar');
        $sheet->setCellValue('F6', 'Saldo');

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A6:F6')->applyFromArray($headerStyle);

        $row = 7;
        $no = 1;
        $saldo = 0;
        $totalMasuk = 0;
        $totalKeluar = 0;
        $totalOperasional = 0;

        foreach ($data as $item) {
            $tanggal = \Carbon\Carbon::parse($item->tanggal_transaksi)->translatedFormat('d F Y');
            $uraian = $item->uraian ?? '-';
            $masuk = $item->jenis === 'pemasukan' ? $item->jumlah : 0;
            $keluar = $item->jenis === 'pengeluaran' ? $item->jumlah : 0;
            $operasional = $item->jenis === 'operasional' ? $item->jumlah : 0;

            $saldo += $masuk - $keluar - $operasional;
            $totalMasuk += $masuk;
            $totalKeluar += $keluar;
            $totalOperasional += $operasional;

            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $tanggal);
            $sheet->setCellValue("C{$row}", $uraian);
            $sheet->setCellValue("D{$row}", $masuk > 0 ? $masuk : '');
            $sheet->setCellValue("E{$row}", $keluar > 0 ? $keluar : '');
            $sheet->setCellValue("F{$row}", $saldo);

            $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

            $row++;
        }

        // Total
        $sheet->setCellValue("C{$row}", "Jumlah");
        $sheet->setCellValue("D{$row}", $totalMasuk > 0 ? $totalMasuk : '');
        $sheet->setCellValue("E{$row}", $totalKeluar > 0 ? $totalKeluar : '');
        $sheet->setCellValue("F{$row}", $saldo);

        $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
            'font' => ['bold' => true],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Tanda tangan
        $row += 2;
        $sheet->setCellValue("E{$row}", "Semarang, " . \Carbon\Carbon::now()->translatedFormat('d F Y'));
        $row += 1;
        $sheet->setCellValue("C{$row}", "Ketua BS Salam Lestari");
        $sheet->setCellValue("E{$row}", "Bendahara");
        $row += 4;
        $sheet->setCellValue("C{$row}", "Suwardi");
        $sheet->setCellValue("E{$row}", "Umihanik Khotrunada");

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = "buku_kas_{$bulanNama}.xlsx";

        // --- solusi: output langsung ---
        if (ob_get_length() > 0) {
            ob_end_clean(); // bersihkan buffer supaya output bersih
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportPdf(Request $request)
    {
        $query = TransaksiNasabah::query();

        if ($request->filled('nasabah')) {
            $query->whereHas('nasabah', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nasabah . '%');
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_transaksi', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
        }

        $data = $query->orderBy('tanggal_transaksi', 'asc')->get();

        $bulanNama = Carbon::createFromDate(
            $request->tahun ?? now()->year,
            $request->bulan ?? now()->month,
            1
        )->translatedFormat('F Y');

        $totalMasuk = $data->where('jenis', 'pemasukan')->sum('jumlah');
        $totalKeluar = $data->where('jenis', 'pengeluaran')->sum('jumlah');
        $totalOperasional = $data->where('jenis', 'operasional')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar - $totalOperasional;

        $pdf = Pdf::loadView('pages.transaksi.pdf', compact(
            'data',
            'bulanNama',
            'totalMasuk',
            'totalKeluar',
            'totalOperasional',
            'saldo'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("buku_kas_{$bulanNama}.pdf");
    }
}
