<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Collection;

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
        
        // Ambil nomor_hp dari session
        $nomor_hp = session('nomor_hp');
        // Panggil fungsi rekomendasi
        $rekomendasi = $this->rekomendasi($nomor_hp);

        return view('guest.home', compact('menus', 'groupedMenus', 'kategori', 'nomor_meja', 'rekomendasi'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if ($query) {
            $menus = Menu::with('kategori')->where('nama_makanan', 'LIKE', '%' . $query . '%')->get();
        } else {
            $menus = Menu::with('kategori')->get();
        }
    
        $groupedMenus = $menus->groupBy(function ($item) {
            return $item->kategori->nama_kategori ?? 'Tanpa Kategori';
        });
        
        $kategori = Kategori::all();
        $nomor_meja = session('nomor_meja');
        
        // Ambil nomor_hp dari session juga saat search
        $nomor_hp = session('nomor_hp');
        $rekomendasi = $this->rekomendasi($nomor_hp);

        return view('guest.home', compact('menus', 'groupedMenus', 'kategori', 'nomor_meja', 'rekomendasi'));
    }
    
    private function rekomendasi($nomor_hp)
    {
        if (!$nomor_hp) {
            return collect(); // Mengembalikan collection kosong
        }

        // Cek apakah nomor HP ini pernah melakukan pesanan
        $pernahPesan = Pesanan::where('nomor_hp', $nomor_hp)->exists();

        if ($pernahPesan) {
            // Kalau pernah, ambil nama_menu yang pernah dipesan lewat DetailPesanan
            $rekomendasiNamaMenu = DetailPesanan::whereHas('pesanan', function($query) use ($nomor_hp) {
                    $query->where('nomor_hp', $nomor_hp);
                })
                ->select('nama_menu')
                ->groupBy('nama_menu')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(5)
                ->pluck('nama_menu');

            return Menu::whereIn('nama_makanan', $rekomendasiNamaMenu)->get();
        } else {
            // Kalau belum pernah pesan, ambil menu paling populer
            $rekomendasiNamaMenu = DetailPesanan::select('nama_menu')
                ->groupBy('nama_menu')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(5)
                ->pluck('nama_menu');

            return Menu::whereIn('nama_makanan', $rekomendasiNamaMenu)->get();
        }
    }
}
