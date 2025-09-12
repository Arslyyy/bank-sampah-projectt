<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NasabahAccountController extends Controller
{
    public function index()
    {
        $nasabah = Auth::user()->nasabah; // Ambil data nasabah yang login
        return view('pages.nasabah.kelolaakun', compact('nasabah'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed', 
            // "confirmed" otomatis cek dengan field `password_baru_confirmation`
        ]);

        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        // Update password baru
        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diganti!');
    }

    public function checkPassword(Request $request)
{
    $user = auth()->user();
    $isMatch = Hash::check($request->password_lama, $user->password);

    return response()->json(['match' => $isMatch]);
}

}
