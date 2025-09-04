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
        $baseQuery = TransaksiNasabah::with(['satuan', 'nasabah', 'jenisSampah']);

        // 🔹 filter nama nasabah
        if ($request->filled('nasabah')) {
            $baseQuery->whereHas('nasabah', function ($q) use ($request) {
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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Buku Kas');

        // ✅ Judul
        $sheet->setCellValue('A1', 'BUKU KAS BANK SAMPAH "SALAM LESTARI" RW 05');
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A2', 'Kel. KEMBANGSARI, KEC. SEMARANG TENGAH, SEMARANG');
        $sheet->mergeCells('A2:F2');

        $bulanNama = Carbon::createFromDate($request->tahun, $request->bulan, 1)->translatedFormat('F Y');
        $sheet->setCellValue('A4', "BULAN : " . $bulanNama);
        $sheet->mergeCells('A4:F4');

        // ✅ Header tabel
        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Tanggal');
        $sheet->setCellValue('C6', 'Uraian');
        $sheet->setCellValue('D6', 'Masuk');
        $sheet->setCellValue('E6', 'Keluar');
        $sheet->setCellValue('F6', 'Saldo');

        // Style header
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

        foreach ($data as $item) {
            $tanggal = Carbon::parse($item->tanggal_transaksi)->translatedFormat('d F Y');
            $uraian = $item->uraian ?? '-';
            $masuk = $item->jenis === 'pemasukan' ? $item->jumlah : 0;
            $keluar = $item->jenis === 'pengeluaran' ? $item->jumlah : 0;

            $saldo += $masuk - $keluar;
            $totalMasuk += $masuk;
            $totalKeluar += $keluar;

            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $tanggal);
            $sheet->setCellValue("C{$row}", $uraian);
            $sheet->setCellValue("D{$row}", $masuk > 0 ? $masuk : '');
            $sheet->setCellValue("E{$row}", $keluar > 0 ? $keluar : '');
            $sheet->setCellValue("F{$row}", $saldo);

            // ✅ Tambahkan border di setiap baris data
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

        // ✅ Total
        $sheet->setCellValue("C{$row}", "Jumlah");
        $sheet->setCellValue("D{$row}", $totalMasuk > 0 ? $totalMasuk : '');
        $sheet->setCellValue("E{$row}", $totalKeluar > 0 ? $totalKeluar : '');
        $sheet->setCellValue("F{$row}", $saldo);


        // Border untuk total
        $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
            'font' => ['bold' => true],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
        $row += 2;
        // ✅ Tanda tangan
        $sheet->setCellValue("E{$row}", "Semarang, " . Carbon::now()->translatedFormat('d F Y'));
        $row += 1;
        $sheet->setCellValue("C{$row}", "Ketua BS Salam Lestari");
        $sheet->setCellValue("E{$row}", "Bendahara");
        $row += 4;
        $sheet->setCellValue("C{$row}", "Suwardi");
        $sheet->setCellValue("E{$row}", "Umihanik Khotrunada");

        // ✅ Auto width
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "buku_kas_{$bulanNama}.xlsx";

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }
}
