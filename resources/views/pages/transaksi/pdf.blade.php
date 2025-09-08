<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Buku Kas - {{ $bulanNama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h3, p { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #f2f2f2; font-weight: bold; }
        .text-left { text-align: left; }
        .no-border { border: none !important; }
        .signature { margin-top: 40px; width: 100%; }
        .signature td { border: none; text-align: center; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">BUKU KAS BANK SAMPAH "SALAM LESTARI" RW 05</h3>
    <p style="text-align: center;">Kel. KEMBANGSARI, KEC. SEMARANG TENGAH, SEMARANG</p>
    <p style="text-align: center;">BULAN : {{ $bulanNama }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Uraian</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1; 
                $saldoBerjalan = 0; 
            @endphp
            @foreach ($data as $item)
                @php
                    $masuk = $item->jenis === 'pemasukan' ? $item->jumlah : 0;
                    $keluar = $item->jenis === 'pengeluaran' ? $item->jumlah : 0;
                    $saldoBerjalan += $masuk - $keluar;
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->translatedFormat('d F Y') }}</td>
                    <td class="text-left">{{ $item->uraian ?? '-' }}</td>
                    <td>{{ $masuk > 0 ? number_format($masuk,0,',','.') : '' }}</td>
                    <td>{{ $keluar > 0 ? number_format($keluar,0,',','.') : '' }}</td>
                    <td>{{ number_format($saldoBerjalan,0,',','.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><b>Jumlah</b></td>
                <td><b>{{ number_format($totalMasuk,0,',','.') }}</b></td>
                <td><b>{{ number_format($totalKeluar,0,',','.') }}</b></td>
                <td><b>{{ number_format($saldo,0,',','.') }}</b></td>
            </tr>
        </tbody>
    </table>

    <table class="signature" style="margin-top:40px;">
        <tr>
            <td width="50%"></td>
            <td>Semarang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Ketua BS Salam Lestari</td>
            <td>Bendahara</td>
        </tr>
        <tr><td colspan="2" style="height: 60px;"></td></tr>
        <tr>
            <td><b>Suwardi</b></td>
            <td><b>Umihanik Khotrunada</b></td>
        </tr>
    </table>
</body>
</html>
