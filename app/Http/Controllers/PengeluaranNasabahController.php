<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use App\Models\MasterNasabah;
use App\Models\MasterJenisSampah;
use App\Models\MasterSatuan;
use Illuminate\Http\Request;

class PengeluaranNasabahController extends Controller
{
    public function index()
    {
        $data = TransaksiNasabah::with(['nasabah', 'jenisSampah', 'satuan'])
                ->where('jenis', 'pengeluaran')
                ->orderBy('tanggal_transaksi', 'desc')
                ->get();

        return view('pages.transaksi.pengeluaran.list', compact('data'));
    }

    public function create()
    {
        $nasabah = MasterNasabah::all();
        $jenisSampah = MasterJenisSampah::all();
        $satuan = MasterSatuan::all();

        return view('pages.transaksi.pengeluaran.form', compact('nasabah', 'jenisSampah', 'satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'master_nasabah_id' => 'required|exists:master_nasabah,id',
            'master_jenis_sampah_id' => 'required|exists:master_jenis_sampah,id',
            'master_satuan_id' => 'required|exists:master_satuan,id',
            'jumlah' => 'required|numeric|min:0',
            'uraian' => 'nullable|string'
        ]);

        $jumlah = str_replace('.', '', $request->jumlah);

        TransaksiNasabah::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'master_nasabah_id' => $request->master_nasabah_id,
            'master_jenis_sampah_id' => $request->master_jenis_sampah_id,
            'master_satuan_id' => $request->master_satuan_id,
            'jumlah' => $request->jumlah,
            'uraian' => $request->uraian,
            'jenis' => 'pengeluaran'
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = TransaksiNasabah::findOrFail($id);
        $nasabah = MasterNasabah::all();
        $jenisSampah = MasterJenisSampah::all();
        $satuan = MasterSatuan::all();

        return view('pages.transaksi.pengeluaran.form', compact('data', 'nasabah', 'jenisSampah', 'satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'master_nasabah_id' => 'required|exists:master_nasabah,id',
            'master_jenis_sampah_id' => 'required|exists:master_jenis_sampah,id',
            'master_satuan_id' => 'required|exists:master_satuan,id',
            'jumlah' => 'required|numeric|min:0',
            'uraian' => 'nullable|string'
        ]);

        $data = TransaksiNasabah::findOrFail($id);
        $jumlah = str_replace('.', '', $request->jumlah);
        $data->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'master_nasabah_id' => $request->master_nasabah_id,
            'master_jenis_sampah_id' => $request->master_jenis_sampah_id,
            'master_satuan_id' => $request->master_satuan_id,
            'jumlah' => $request->jumlah,
            'uraian' => $request->uraian
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = TransaksiNasabah::findOrFail($id);
        $data->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus');
    }
}
