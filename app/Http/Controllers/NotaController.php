<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use Illuminate\Http\Request;


class NotaController extends Controller
{
    public function show(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:users,nasabah_id',
            'tanggal' => 'required|date',
        ]);

        $data = TransaksiNasabah::with('jenisSampah') // eager load jenis sampah
            ->where('master_nasabah_id', $request->nasabah_id)
            ->whereDate('tanggal_transaksi', $request->tanggal)
            ->get();

        return response()->json($data);
    }
}