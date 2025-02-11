<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PesananController extends Controller
{
    public function get()
    {
        return response()->json(Session::get('cart', []));
    }

    public function add(Request $request)
    {
        $cart = Session::get('cart', []);
        $cart[] = [
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price
        ];
        Session::put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $cart = Session::get('cart', []);
        $cart = array_filter($cart, function ($item) use ($request) {
            return $item['id'] != $request->id;
        });

        Session::put('cart', array_values($cart));
        return response()->json(['success' => true]);
    }

    public function checkout()
    {
        return view('checkout', ['cart' => Session::get('cart', [])]);
    }

    
}
