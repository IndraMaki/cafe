<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    // **Tampilkan halaman daftar kategori**
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.kategori', compact('kategori'));
    }

    // **Simpan kategori baru**
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = null;

        // **Simpan logo jika ada**
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // **Simpan kategori ke database**
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.viewkategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // **Tampilkan daftar kategori di halaman viewkategori**
    public function view()
    {
        $kategori = Kategori::all();
        return view('admin.viewkategori', compact('kategori'));
    }
}
