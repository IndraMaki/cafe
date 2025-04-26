<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\DetailPesanan;

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


        $cartKey = "cart_$nomorMeja";
        $cart = session()->get($cartKey, []);

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return view('guest.keranjang', compact('cart', 'totalItems', 'totalPrice', 'nomorMeja'));
    }

    public function pesan(Request $request)
    {
        $nomor_meja = session('nomor_meja');
        $nomor_hp = session('nomor_hp');

        $cartKey = "cart_$nomor_meja";
        $cart = session($cartKey, []);

        \Log::info('Cart:', $cart);
        \Log::info('Nomor Meja: ' . $nomor_meja);
        \Log::info('Nomor HP: ' . $nomor_hp);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        // Simpan ke database
        $pesanan = Pesanan::create([
            'nomor_meja' => $nomor_meja,
            'nomor_hp' => $nomor_hp,
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'nama_menu' => $item['name'],
                'harga' => $item['price'],
                'jumlah' => $item['quantity'],
            ]);
        }

        // Kosongkan keranjang
        session()->forget($cartKey);

        return redirect('/done')->with('success', 'Pesanan berhasil dikirim');
    }
    // Tambah jumlah item
    public function increaseQuantity(Request $request)
    {
        $nomorMeja = session('nomor_meja');
        $cartKey = "cart_$nomorMeja";
        $cart = session()->get($cartKey, []);
        
        $id = $request->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put($cartKey, $cart);
        }

        return response()->json(['success' => true]);
    }

    // Kurangi jumlah item
    public function decreaseQuantity(Request $request)
    {
        $nomorMeja = session('nomor_meja');
        $cartKey = "cart_$nomorMeja";
        $cart = session()->get($cartKey, []);
        
        $id = $request->id;

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
                session()->put($cartKey, $cart);
            } else {
                unset($cart[$id]);
                session()->put($cartKey, $cart);
            }
        }

        return response()->json(['success' => true]);
    }
    // Hapus item dari cart
    public function removeFromCart(Request $request)
    {
        $nomorMeja = session('nomor_meja');
        $cartKey = "cart_$nomorMeja";
        $cart = session()->get($cartKey, []);

        $id = $request->id;

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put($cartKey, $cart);
        }

        return response()->json(['success' => true]);
    }





}
