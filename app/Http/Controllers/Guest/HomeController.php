<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori; 

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with('kategori')->get();
        $groupedMenus = $menus->groupBy(function ($item) {
            return $item->kategori->nama_kategori ?? 'Tanpa Kategori';
        });
        $kategori = Kategori::all();
        
        $nomor_meja = $request->query('nomor_meja');
        if ($nomor_meja) {
            session(['nomor_meja' => $nomor_meja]);
        }
    
        return view('guest.home', compact('menus','groupedMenus', 'kategori', 'nomor_meja'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if ($query) {
            // Cari menu berdasarkan nama
            $menus = Menu::with('kategori')->where('nama_makanan', 'LIKE', '%' . $query . '%')->get();
        } else {
            // Ambil semua menu jika tidak ada query pencarian
            $menus = Menu::with('kategori')->get();
        }
    
        // Kelompokkan menu berdasarkan kategori
        $groupedMenus = $menus->groupBy(function ($item) {
            return $item->kategori->nama_kategori ?? 'Tanpa Kategori';
        });
        
        $kategori = Kategori::all();
        $nomor_meja = session('nomor_meja'); // ambil dari session, bukan dari query lagi
        
        return view('guest.home', compact('menus', 'groupedMenus', 'kategori', 'nomor_meja'));
    }
    
    
}
