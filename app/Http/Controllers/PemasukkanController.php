<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use App\Models\MasterSatuan;
use Illuminate\Http\Request;

class PemasukkanController extends Controller
{
    public function index()
    {
        $data = TransaksiNasabah::with(['satuan'])
            ->where('jenis', 'pemasukan')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        return view('pages.transaksi.pemasukan.list', compact('data'));
    }

    public function create()
    {
        $satuan = MasterSatuan::all();
        return view('pages.transaksi.pemasukan.form', compact('satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'master_satuan_id' => 'required|exists:master_satuan,id',
            'jumlah' => 'required|numeric|min:0',
            'uraian' => 'nullable|string'
        ]);

        $jumlah = str_replace('.', '', $request->jumlah);

        TransaksiNasabah::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'master_satuan_id' => $request->master_satuan_id,
            'jumlah' => $jumlah,
            'uraian' => $request->uraian,
            'jenis' => 'pemasukan'
        ]);

        return redirect()->route('pemasukkan.index')->with('success', 'Data pemasukan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = TransaksiNasabah::findOrFail($id);
        $satuan = MasterSatuan::all();

        return view('pages.transaksi.pemasukan.form', compact('data', 'satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'master_satuan_id' => 'required|exists:master_satuan,id',
            'jumlah' => 'required|numeric|min:0',
            'uraian' => 'nullable|string'
        ]);

        $data = TransaksiNasabah::findOrFail($id);
        $jumlah = str_replace('.', '', $request->jumlah);
        $data->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'master_satuan_id' => $request->master_satuan_id,
            'jumlah' => $jumlah,
            'uraian' => $request->uraian
        ]);

        return redirect()->route('pemasukkan.index')->with('success', 'Data pemasukan berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = TransaksiNasabah::findOrFail($id);
        $data->delete();

        return redirect()->route('pemasukkan.index')->with('success', 'Data pemasukan berhasil dihapus');
    }
}
