<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginGController extends Controller
{
    public function index()
    {
        // Tidak perlu session nomor_meja lagi
        return view('guest.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_hp' => 'required|numeric|digits_between:10,15',
        ], [
            'nomor_hp.numeric' => 'Nomor HP harus berupa angka.',
            'nomor_hp.digits_between' => 'Nomor HP harus terdiri dari 10 sampai 15 digit.',
        ]);

        // Simpan nomor_hp di session saja
        session(['nomor_hp' => $request->nomor_hp]);

        return redirect()->route('guest.home');
    }

    public function logout()
    {
        // Hapus session nomor_hp dan cart (kalau ada)
        session()->forget(['nomor_hp', 'cart']);

        return view('guest.logoutinfo');
    }
}
