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
    $nomorMeja = session('nomor_meja');


    $cartKey = "cart_$nomorMeja";
    $cart = session()->get($cartKey, []);
    
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

    session()->put($cartKey, $cart);

    return response()->json(['message' => 'Berhasil ditambahkan ke keranjang!']);
}

    

public function index()
{
    $nomorMeja = session('nomor_meja');

    if (!$nomorMeja) {
        return redirect()->route('guest.pilih-meja'); // misal ada halaman pilih meja
    }

    $cartKey = "cart_$nomorMeja";
    $cart = session($cartKey, []);

    $totalItems = array_sum(array_column($cart, 'quantity'));
    $totalPrice = array_reduce($cart, function($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);

    return view('guest.keranjang', compact('cart', 'totalItems', 'totalPrice', 'nomorMeja'));
}

}
