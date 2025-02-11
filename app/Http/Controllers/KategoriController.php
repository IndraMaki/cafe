<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    // Menampilkan halaman kategori
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori', compact('kategoris'));
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kategoris,nama'
        ]);

        Kategori::create(['nama' => $request->nama]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|unique:kategoris,nama,'.$id
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
