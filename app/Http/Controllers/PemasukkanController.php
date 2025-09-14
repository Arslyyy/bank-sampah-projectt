<?php

namespace App\Http\Controllers;

use App\Models\TransaksiNasabah;
use App\Models\MasterSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PemasukkanController extends Controller
{
    /**
     * Tampilkan daftar pemasukan dengan filter bulan & tahun.
     */
    public function index(Request $request)
    {
        $query = TransaksiNasabah::where('jenis', 'pemasukan');

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_transaksi', $request->bulan);
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
        }

        $data = $query->orderBy('tanggal_transaksi', 'desc')->paginate(10);

        return view('pages.transaksi.pemasukan.list', compact('data'));
    }

    /**
     * Form tambah pemasukan baru.
     */
    public function create()
    {
        return view('pages.transaksi.pemasukan.form', [
            'idTransaksi' => $this->generateUniqueIdTransaksi(),
        ]);
    }

    /**
     * Simpan data pemasukan baru.
     */
    public function store(Request $request)
    {
        // Bersihkan angka agar lolos numeric
        $cleanedJumlah = array_map(function ($j) {
            return str_replace(['.', ',', 'Rp', ' '], '', $j);
        }, $request->jumlah ?? []);

        $request->merge(['jumlah' => $cleanedJumlah]);

        // Validasi
        $request->validate([
            'id_transaksi.*'      => 'required|string',
            'tanggal_transaksi.*' => 'required|date',
            'master_satuan_id.*'  => 'nullable|exists:master_satuan,id',
            'jumlah.*'            => 'required|numeric|min:0',
            'uraian.*'            => 'nullable|string',
            'image.*'             => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $idList      = $request->id_transaksi;
        $tanggalList = $request->tanggal_transaksi;
        $satuanList  = $request->master_satuan_id;
        $jumlahList  = $request->jumlah;
        $uraianList  = $request->uraian;
        $imageList   = $request->file('image');

        foreach ($tanggalList as $i => $tanggal) {
            $data = [
                'id_transaksi'      => $idList[$i],
                'tanggal_transaksi' => $tanggal,
                'master_satuan_id'  => $satuanList[$i] ?? null,
                'jumlah'            => $jumlahList[$i],
                'uraian'            => $uraianList[$i] ?? null,
                'jenis'             => 'pemasukan',
            ];

            // Upload nota jika ada
            if (isset($imageList[$i])) {
                $path = $imageList[$i]->store('pemasukan', 'public');
                $data['image'] = $path;
            }

            TransaksiNasabah::create($data);
        }

        return redirect()
            ->route('pemasukkan.index')
            ->with('success', 'Data pemasukan berhasil ditambahkan');
    }

    /**
     * Form edit pemasukan.
     */
    public function edit($id)
    {
        $data   = TransaksiNasabah::findOrFail($id);
        $satuan = MasterSatuan::all();

        return view('pages.transaksi.pemasukan.form', compact('data', 'satuan'));
    }

    /**
     * Update pemasukan.
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'jumlah' => str_replace('.', '', $request->jumlah),
        ]);

        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'master_satuan_id'  => 'nullable|exists:master_satuan,id',
            'jumlah'            => 'required|numeric|min:0',
            'uraian'            => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $data = TransaksiNasabah::findOrFail($id);

        $updateData = [
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'master_satuan_id'  => $request->master_satuan_id,
            'jumlah'            => $request->jumlah,
            'uraian'            => $request->uraian,
        ];

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            if ($data->image && Storage::disk('public')->exists($data->image)) {
                Storage::disk('public')->delete($data->image);
            }
            $path = $request->file('image')->store('pemasukan', 'public');
            $updateData['image'] = $path;
        }

        $data->update($updateData);

        return redirect()
            ->route('pemasukkan.index')
            ->with('success', 'Data pemasukan berhasil diupdate');
    }

    /**
     * Hapus pemasukan.
     */
    public function destroy($id)
    {
        $data = TransaksiNasabah::findOrFail($id);

        if ($data->image && Storage::disk('public')->exists($data->image)) {
            Storage::disk('public')->delete($data->image);
        }

        $data->delete();

        return redirect()
            ->route('pemasukkan.index')
            ->with('success', 'Data pemasukan berhasil dihapus');
    }

    /**
     * Generate ID transaksi unik 6 karakter.
     */
    private function generateUniqueIdTransaksi()
    {
        do {
            $id = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        } while (TransaksiNasabah::where('id_transaksi', $id)->exists());

        return $id;
    }

    public function nota($id)
    {
        $data = TransaksiNasabah::findOrFail($id);

        return view('pages.transaksi.pemasukan.nota', compact('data'));
    }

}
