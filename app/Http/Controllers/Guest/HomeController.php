<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori; // Tambahkan model Kategori

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with('kategori')->get();
        $kategori = Kategori::all();
        
        $nomor_meja = $request->query('nomor_meja');
        if ($nomor_meja) {
            session(['nomor_meja' => $nomor_meja]);
        }
    
        return view('guest.home', compact('menus', 'kategori', 'nomor_meja'));
    }
    
    
}
