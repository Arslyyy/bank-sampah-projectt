<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OperasionalController extends Controller
{
    /**
     * Tampilkan daftar operasional
     */
    public function index(Request $request)
    {
        $query = TransaksiNasabah::where('jenis', 'operasional');

        // Filter tanggal
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_transaksi', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
        }

        $data = $query->orderBy('tanggal_transaksi', 'desc')->paginate(10);

        return view('pages.operasional.list', compact('data'));
    }

    /**
     * Form tambah
     */
    public function create()
    {
        return view('pages.operasional.form');
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'jenis_operasional' => 'required|string|max:250',
            'jumlah' => 'required',
            'uraian' => 'nullable|string',
        ]);

        $jumlah = str_replace('.', '', $request->jumlah);

        TransaksiNasabah::create([
            'id_transaksi'       => 'OPR-' . strtoupper(Str::random(6)), // generate kode unik
            'tanggal_transaksi'  => $request->tanggal_transaksi,
            'jenis'              => 'operasional',
            'jenis_operasional'  => $request->jenis_operasional,
            'jumlah'             => $jumlah,
            'uraian'             => $request->uraian,
        ]);

        return redirect()->route('operasional.index')
                         ->with('success', 'Data operasional berhasil ditambahkan');
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $data = TransaksiNasabah::where('jenis', 'operasional')->findOrFail($id);
        return view('pages.operasional.form', compact('data'));
    }

    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'jenis_operasional' => 'required|string|max:250',
            'jumlah' => 'required',
            'uraian' => 'nullable|string',
        ]);

        $jumlah = str_replace('.', '', $request->jumlah);

        $data = TransaksiNasabah::where('jenis', 'operasional')->findOrFail($id);
        $data->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jenis_operasional' => $request->jenis_operasional,
            'jumlah'            => $jumlah,
            'uraian'            => $request->uraian,
        ]);

        return redirect()->route('operasional.index')
                         ->with('success', 'Data operasional berhasil diupdate');
    }

    /**
     * Hapus
     */
    public function destroy($id)
    {
        $data = TransaksiNasabah::where('jenis', 'operasional')->findOrFail($id);
        $data->delete();

        return redirect()->route('operasional.index')->with('success', 'Data operasional berhasil dihapus');
    }
}
