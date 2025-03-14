<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $nomorMeja = $request->query('nomor_meja'); // Ambil parameter nomor_meja dari URL

        return view('guest.home', compact('nomorMeja'));
    }
}
