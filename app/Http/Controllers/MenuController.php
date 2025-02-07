<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    // Menampilkan daftar menu beserta kategori options
    public function index()
    {
        $menus = Menu::all(); // Mendapatkan semua data menu
        $kategoriOptions = ['MANTUL', 'JAJANAN', 'SEGER', 'MANIS']; // Opsi kategori
        return view('admin.menu', compact('menus', 'kategoriOptions'));
    }

    // Menyimpan data menu baru
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required|in:MANTUL,JAJANAN,SEGER,MANIS',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Menyimpan gambar
        $gambarPath = $request->file('gambar')->store('menu_images', 'public');

        // Menyimpan data menu ke database
        Menu::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    // Menampilkan form edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id); // Menemukan menu berdasarkan ID
        $kategoriOptions = ['MANTUL', 'JAJANAN', 'SEGER', 'MANIS']; // Opsi kategori
        return view('admin.editmenu', compact('menu', 'kategoriOptions')); // Menampilkan form edit menu
    }

    // Memperbarui data menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id); // Menemukan menu berdasarkan ID

        // Validasi inputan
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required|in:MANTUL,JAJANAN,SEGER,MANIS',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Menangani gambar jika ada file gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama (jika ada)
            if ($menu->gambar) {
                \Storage::delete('public/' . $menu->gambar);
            }
            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('menu_images', 'public');
            $menu->gambar = $gambarPath;
        }

        // Update data menu
        $menu->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    // Menghapus data menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id); // Menemukan menu berdasarkan ID

        // Hapus gambar menu (jika ada)
        if ($menu->gambar) {
            \Storage::delete('public/' . $menu->gambar);
        }

        // Hapus data menu dari database
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    // Menampilkan form untuk menambah menu
    public function create()
    {
    $kategoriOptions = ['MANTUL', 'JAJANAN', 'SEGER', 'MANIS']; // Opsi kategori
    return view('admin.addmenu', compact('kategoriOptions')); // Menampilkan form tambah menu
    }

}
