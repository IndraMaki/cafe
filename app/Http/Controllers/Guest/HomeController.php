<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\DetailPesanan;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('nomor_hp')) {
            return redirect()->route('guest.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $menus = Menu::with('kategori')->get();
        $groupedMenus = $menus->groupBy(function ($item) {
            return $item->kategori->nama_kategori ?? 'Tanpa Kategori';
        });

        $kategori = Kategori::all();
        $nomor_hp = session('nomor_hp');
        $rekomendasi = $this->rekomendasi($nomor_hp);

        $cartKey = "cart_$nomor_hp";
        $cart = session()->get($cartKey, []);

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return view('guest.home', compact('menus', 'groupedMenus', 'kategori', 'rekomendasi', 'cart',
        'totalItems',
        'totalPrice',
        'nomor_hp'));
    }

    public function search(Request $request)
    {
        if (!session()->has('nomor_hp')) {
            return redirect()->route('guest.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $query = $request->input('query');

        $menus = $query
            ? Menu::with('kategori')->where('nama_makanan', 'LIKE', '%' . $query . '%')->get()
            : Menu::with('kategori')->get();

        $groupedMenus = $menus->groupBy(function ($item) {
            return $item->kategori->nama_kategori ?? 'Tanpa Kategori';
        });

        $kategori = Kategori::all();
        $nomor_hp = session('nomor_hp');
        $rekomendasi = $this->rekomendasi($nomor_hp);

        return view('guest.home', compact('menus', 'groupedMenus', 'kategori', 'rekomendasi'));
    }

    private function rekomendasi($nomor_hp)
    {
        if (!$nomor_hp) {
            return collect();
        }

        $pernahPesan = Pesanan::where('nomor_hp', $nomor_hp)->exists();

        $rekomendasiNamaMenu = DetailPesanan::when($pernahPesan, function ($query) use ($nomor_hp) {
                return $query->whereHas('pesanan', function ($q) use ($nomor_hp) {
                    $q->where('nomor_hp', $nomor_hp);
                });
            })
            ->select('nama_menu')
            ->groupBy('nama_menu')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->pluck('nama_menu');

        return Menu::whereIn('nama_makanan', $rekomendasiNamaMenu)->get();
    }
}
