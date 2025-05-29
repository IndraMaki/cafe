<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;

class LoginGController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah session 'nomor_meja' sudah ada, jika belum baru set
        if (!session()->has('nomor_meja')) {
            $nomor_meja = $request->query('nomor_meja');
            session(['nomor_meja' => $nomor_meja]);
        } else {
            $nomor_meja = session('nomor_meja');
        }

        return view('guest.login', compact('nomor_meja'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nomor_hp' => 'required|numeric|digits_between:10,15',
            'nomor_meja' => 'required|integer',
        ], [
        'nomor_hp.numeric' => 'Nomor HP harus berupa angka.',
        'nomor_hp.digits_between' => 'Nomor HP harus terdiri dari 10 sampai 15 digit.',
        ]);
    
        // Simpan data ke session, pastikan nomor meja di-update
        session([
            'nomor_hp' => $request->nomor_hp,
            'nomor_meja' => $request->nomor_meja, // Update nomor meja
        ]);
    
        return redirect()->route('guest.home');
    }
    
    public function logout()
    {
        // Hapus semua session
        session()->forget(['nomor_hp', 'nomor_meja', 'cart']);
    
        // Tampilkan halaman info logout
        return view('guest.logoutinfo'); 
    }
    

}
