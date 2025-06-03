<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Midtrans\Snap;
use Midtrans\Config;


class KeranjangController extends Controller
{
    public function addToCart(Request $request)
    {
        $nomor_hp = session('nomor_hp');


        $cartKey = "cart_$nomor_hp";
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
        $nomor_hp = session('nomor_hp');


        $cartKey = "cart_$nomor_hp";
        $cart = session()->get($cartKey, []);

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return view('guest.keranjang', compact('cart', 'totalItems', 'totalPrice', 'nomor_hp'));
    }

    public function pesan(Request $request)
    {
        $nomor_hp = session('nomor_hp');
        $cart = session("cart_$nomor_hp", []);

        \Log::info('Cart:', $cart);
        \Log::info('Nomor HP: ' . $nomor_hp);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        
        
        $pesanan = Pesanan::create([
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

        session()->forget("cart_$nomor_hp");

        return redirect('/done')->with('success', 'Pesanan berhasil dikirim');
    }


    // public function saveCart(Request $request)
    // {
    //     $nomor_hp = $request->input('nomor_hp');
    //     $cart = $request->input('cart');

    //     session()->put("cart_$nomor_hp", $cart);
    //     return response()->json(['success' => true]);
    // }

    
    // Tambah jumlah item
    public function increaseQuantity(Request $request)
    {
        $nomor_hp = session('nomor_hp');
        $cartKey = "cart_$nomor_hp";
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
        $nomor_hp = session('nomor_hp');
        $cartKey = "cart_$nomor_hp";
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
        $nomor_hp = session('nomor_hp');
        $cartKey = "cart_$nomor_hp";
        $cart = session()->get($cartKey, []);

        $id = $request->id;

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put($cartKey, $cart);
        }

        return response()->json(['success' => true]);
    }




    public function pesanMidtrans(Request $request)
    {
        $nomor_hp = session('nomor_hp');
        $cart = session("cart_$nomor_hp", []);

        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;

        $orderId = 'ORDER-' . time();

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => $nomor_hp,
            ],
        ];

        $snapToken = Snap::getSnapToken($payload);

        // Simpan sementara data di session
        session()->put("cart_token_$orderId", [
            'cart' => $cart,
            'nomor_hp' => $nomor_hp,
        ]);

        return response()->json(['snap_token' => $snapToken, 'order_id' => $orderId]);
    }

    public function pesananSukses(Request $request)
    {
        $orderId = $request->order_id;
        $sessionData = session("cart_token_$orderId");

        if (!$sessionData) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 400);
        }

        $nomor_hp = $sessionData['nomor_hp'];
        $cart = $sessionData['cart'];

        $pesanan = Pesanan::create([
            'nomor_hp' => $nomor_hp,
            'status' => 'pending', // Bisa kamu sesuaikan
        ]);

        foreach ($cart as $item) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'nama_menu' => $item['name'],
                'harga' => $item['price'],
                'jumlah' => $item['quantity'],
            ]);
        }

        session()->forget("cart_$nomor_hp");
        session()->forget("cart_token_$orderId");

        return response()->json(['success' => true]);
    }


}
