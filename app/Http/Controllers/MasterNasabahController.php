<?php

namespace App\Http\Controllers;

use App\Models\MasterNasabah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MasterNasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = MasterNasabah::all();
        return view('pages.nasabah.list', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [];
        return view('pages.nasabah.form', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate form
        $this->validate($request, [
            'nama'   => 'required|min:3',
            'alamat' => 'required|min:5',
            'email'  => 'required|email|unique:users,email', // untuk akun nasabah
            'password' => 'required|min:6',
        ]);

        // buat data nasabah
        $nasabah = MasterNasabah::create([
            'nama'   => $request->nama,
            'alamat' => $request->alamat,
        ]);

        // buat akun login untuk nasabah di tabel users
        User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // password sesuai input admin
            'role'     => 'nasabah',
            'nasabah_id' => $nasabah->id,
        ]);


        return redirect()->route('nasabah.index')->with(['success' => 'Data Nasabah & Akun Login Berhasil Dibuat!']);
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit(string $id)
{
    $data = MasterNasabah::with('user')->findOrFail($id);
    return view('pages.nasabah.form', compact('data'));
}


public function update(Request $request, string $id)
{
    $this->validate($request, [
        'nama'   => 'required|min:3',
        'alamat' => 'required|min:5',
        'email'  => 'required|email|unique:users,email,' . $id, // supaya email bisa tetap sama
        'password' => 'nullable|min:6', // boleh kosong saat update
    ]);

    $data = MasterNasabah::findOrFail($id);
    $user = User::where('nasabah_id', $data->id)->first();

    // update data nasabah
    $data->update([
        'nama'   => $request->nama,
        'alamat' => $request->alamat,
    ]);

    // update akun user
    $user->update([
        'name'  => $request->nama,
        'email' => $request->email,
        'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
    ]);

    return redirect()->route('nasabah.index')->with(['success' => 'Data Nasabah & Akun Login Berhasil Diubah!']);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = MasterNasabah::findOrFail($id);

            // jika ingin ikut hapus akun user
            User::where('nasabah_id', $data->id)->delete();

            $data->delete();

            return redirect()->route('nasabah.index')->with(['success' => 'Data Nasabah & Akun Berhasil Dihapus!']);
        } catch (\Exception $e) {
            return redirect()->route('nasabah.index')->with(['error' => 'Gagal menghapus data.']);
        }
    }
}
