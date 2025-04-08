<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with('kategori')->get();
        $kategori = Kategori::all();
        $nomor_meja = $request->query('nomor_meja'); // Ambil nomor meja dari URL
    
        return view('guest.keranjang', compact('menus', 'kategori', 'nomor_meja'));
    }
    
}
