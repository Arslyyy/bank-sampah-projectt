<?php

namespace App\Http\Controllers;

use App\Models\MasterJenisSampah;
use App\Models\MasterNasabah;
use App\Models\MasterSatuan;
use App\Models\TransaksiNasabah;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiNasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = TransaksiNasabah::all();
        return view('pages.transaksi.list', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = null;
        $nasabah = MasterNasabah::all();
        $j_sampah = MasterJenisSampah::all();
        $satuan = MasterSatuan::all();
        return view('pages.transaksi.form', compact('data', 'nasabah', 'j_sampah','satuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $this->validate($request, [
        'tanggal_transaksi' => 'required',
        'id_nasabah'        => 'required',
        'id_jenis_sampah'   => 'required',
        'satuans'           => 'required',
        'satuan_status'     => 'required'
    ]);

    $date = Carbon::createFromFormat('d/m/Y H:i A', $request->tanggal_transaksi)
                  ->format('Y-m-d H:i:s');

    TransaksiNasabah::create([
    'tanggal_transaksi'       => $date,
    'master_nasabah_id'       => $request->id_nasabah,
    'master_jenis_sampah_id'  => $request->id_jenis_sampah,
    'master_satuan_id'        => $request->satuan_status,
    'jumlah'                  => $request->satuans,
    ]);


    return redirect()->route('transaksi.index')->with(['success' => 'Data Berhasil Disimpan!']);
}


    /**
     * Display the specified resource.
     */
    public function show(TransaksiNasabah $transaksiNasabah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //
        $data = TransaksiNasabah::findOrFail($id);
        $nasabah = MasterNasabah::all();
        $j_sampah = MasterJenisSampah::all();
        $satuan = MasterSatuan::all();
        return view('pages.transaksi.form', compact('data', 'nasabah', 'j_sampah', 'satuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $this->validate($request, [
            'tanggal_transaksi' => 'required',
            'master_nasabah_id' => 'required',
            'master_jenis_sampah_id' => 'required',
            'master_satuan_id' => 'required',
            'satuan_status' => 'required'
        ]);

        $date = Carbon::createFromFormat('d/m/Y H:i A', $request->tanggal_transaksi)
                  ->format('Y-m-d H:i:s');

        //get post by ID
        $data = TransaksiNasabah::findOrFail($id);

        $data->update([
            'tanggal_transaksi' => $date,
            'master_nasabah_id' => $request->id_nasabah,
            'master_jenis_sampah_id' => $request->id_jenis_sampah,
            'master_satuan_id' => $request->satuans,
            'satuan_status' => $request->satuan_status,
        ]);

        return redirect()->route('transaksi.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $transaksi = TransaksiNasabah::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with(['success' => 'Data Berhasil Di Hapus!']);
    }
}
