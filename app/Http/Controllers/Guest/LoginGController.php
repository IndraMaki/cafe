<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // pakai model User

class LoginGController extends Controller
{
    public function index()
    {
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

        $nomor_hp = $request->nomor_hp;

        // Simpan ke session
        session(['nomor_hp' => $nomor_hp]);

        // Simpan ke tabel users jika belum ada
        User::firstOrCreate(['nomor_hp' => $nomor_hp]);

        return redirect()->route('guest.home');
    }

    public function logout()
    {
        session()->forget(['nomor_hp', 'cart']);
        return view('guest.logoutinfo');
    }
}
