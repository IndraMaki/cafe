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
        $nomor_meja = $request->query('nomor_meja');
        return view('guest.login', compact('nomor_meja'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nomor_hp' => 'required|string|max:15',
            'nomor_meja' => 'required|integer',
        ]);
    
        // Simpan data ke session
        session([
            'nomor_hp' => $request->nomor_hp,
            'nomor_meja' => $request->nomor_meja,
        ]);
    
        return redirect()->route('guest.home');
    }
    
    
    
}
