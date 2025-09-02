<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiNasabah;
use Illuminate\Support\Facades\Auth;

class HomeNasabahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // Ambil transaksi sesuai nasabah yang login
        $datas = TransaksiNasabah::with(['jenisSampah', 'satuan'])
                    ->where('master_nasabah_id', $user->id) // sesuaikan dengan id di tabel master_nasabah
                    ->get();

        return view('dashboard.home', compact('datas'));
    }
}
