<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;

class KeranjangController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
    
        $id = $request->id;
    
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $id,
                "name" => $request->name,
                "price" => $request->price,
                "image" => $request->image,
                "quantity" => 1
            ];
        }
    
        session()->put('cart', $cart);
    
        return response()->json(['message' => 'Berhasil ditambahkan ke keranjang!']);
    }
    

    public function index()
    {
        $cart = session('cart', []); // ambil dari session, kalau nggak ada default array kosong
    
        // Hitung total item dan total harga
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    
        $tableNumber = session('table_number'); // kalau kamu simpan nomor meja di session
    
        return view('guest.keranjang', compact('cart', 'totalItems', 'totalPrice', 'tableNumber'));
    }
}
