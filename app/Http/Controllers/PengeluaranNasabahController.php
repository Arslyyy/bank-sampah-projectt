<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use App\Models\MasterNasabah;
use App\Models\MasterJenisSampah;
use App\Models\MasterSatuan;
use App\Models\MasterHargaSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengeluaranNasabahController extends Controller
{
    /**
     * Tampilkan daftar pengeluaran
     */
    public function index(Request $request)
    {
        $query = TransaksiNasabah::with(['nasabah', 'jenisSampah', 'satuan'])
            ->where('jenis', 'pengeluaran');
        
        // 🔍 Filter ID Transaksi
        if ($request->filled('id_transaksi')) {
            $query->where('id_transaksi', 'like', '%' . $request->id_transaksi . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.transaksi.pengeluaran.list', compact('data'));
    }

    /**
     * Form tambah pengeluaran
     */
    public function create()
    {
        $nasabah = MasterNasabah::all();
        $jenisSampah = MasterJenisSampah::all();
        $satuan = MasterSatuan::all();

        return view('pages.transaksi.pengeluaran.form', compact('nasabah', 'jenisSampah', 'satuan'));
    }

    /**
     * Simpan pengeluaran baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $rules = [
            'tanggal_transaksi.*' => 'required|date',
            'master_nasabah_id.*' => 'nullable|exists:master_nasabah,id',
            'id_master_jenis_sampah.*' => 'nullable|exists:master_jenis_sampah,id',
            'master_satuan_id.*' => 'nullable|exists:master_satuan,id',
            'total.*' => 'required|numeric|min:0',
        ];

        $request->validate($rules);

        $count = count($request->tanggal_transaksi ?? []);

        for ($i = 0; $i < $count; $i++) {
            // Ambil jumlah dari total-raw, bukan dari berat
            $jumlah = $request->total[$i] ?? 0;
            $jumlah = (float) str_replace(['.', ','], ['', '.'], $jumlah);

        TransaksiNasabah::create([
            'id_transaksi' => $request->id_transaksi[$i] ?? $this->generateIdTransaksi(),
            'tanggal_transaksi' => $request->tanggal_transaksi[$i] ?? null,
            'master_nasabah_id' => $request->master_nasabah_id[$i] ?? null,
            'master_jenis_sampah_id' => $request->id_master_jenis_sampah[$i] ?? null,
            'master_satuan_id' => $request->master_satuan_id[$i] ?? null,
            'jumlah_berat' => (float) str_replace('.', '', $request->total[$i] ?? 0), // berat
            'jumlah' => (float) str_replace('.', '', $request->jumlah[$i] ?? 0), // total harga
            'jenis' => 'pengeluaran',
        ]);

        }

        return redirect()->route('pengeluaran.index')
                        ->with('success', 'Data pengeluaran berhasil ditambahkan');
    }

    /**
     * Form edit pengeluaran
     */
    public function edit($id)
    {
        $data = TransaksiNasabah::findOrFail($id);
        $nasabah = MasterNasabah::all();
        $jenisSampah = MasterJenisSampah::all();
        $satuan = MasterSatuan::all();

        return view('pages.transaksi.pengeluaran.form', compact('data', 'nasabah', 'jenisSampah', 'satuan'));
    }

    /**
     * Update pengeluaran
     */
    public function update(Request $request, $id)
    {
        // Pastikan nilai jumlah dan total diubah jadi angka
        $jumlah_berat = isset($request->total) ? (float) str_replace('.', '', $request->total) : 0;
        $jumlah = isset($request->jumlah) ? (float) str_replace('.', '', $request->jumlah) : 0;

        // Validasi input
        $rules = [
            'tanggal_transaksi' => 'required|date',
            'master_nasabah_id' => 'nullable|exists:master_nasabah,id',
            'id_master_jenis_sampah' => 'nullable|exists:master_jenis_sampah,id',
            'master_satuan_id' => 'nullable|exists:master_satuan,id',
            'jumlah' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ];

        $request->validate($rules);

        $data = TransaksiNasabah::findOrFail($id);

        // Update data
        $data->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'master_nasabah_id' => $request->master_nasabah_id ?? null,
            'master_jenis_sampah_id' => $request->id_master_jenis_sampah ?? null,
            'master_satuan_id' => $request->master_satuan_id ?? null,
            'jumlah_berat' => $jumlah_berat, // berat
            'jumlah' => $jumlah,             // total harga
            'jenis' => 'pengeluaran',
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diupdate');
    }



    /**
     * Hapus pengeluaran
     */
    public function destroy($id)
    {
        $data = TransaksiNasabah::findOrFail($id);

        if ($data->image && Storage::exists('public/' . $data->image)) {
            Storage::delete('public/' . $data->image);
        }

        $data->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus');
    }

    /**
     * Generate ID Transaksi unik
     */
    private function generateIdTransaksi()
    {
        return 'TRX' . mt_rand(100000, 999999);
    }

    // ambil harga sampah
    public function getHarga($id)
    {
        $harga = MasterHargaSampah::where('id_master_jenis_sampah', $id)->first();

        return response()->json([
            'harga' => $harga ? $harga->harga_sampah : 0
        ]);
    }

    
}
