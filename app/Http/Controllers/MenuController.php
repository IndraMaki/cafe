<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    // Menampilkan daftar menu di halaman admin
    public function index()
    {
        $menus = Menu::all();
        $kategoriOptions = ['MANTUL', 'JAJANAN', 'SEGER', 'MANIS'];
        return view('admin.menu', compact('menus', 'kategoriOptions'));
    }

    // Menampilkan daftar menu untuk pengguna di halaman user
    public function userIndex()
    {
        $menus = Menu::all();
        return view('user.index', compact('menus'));
    }

    // Menyimpan data menu baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'keterangan' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required|in:MANTUL,JAJANAN,SEGER,MANIS',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambarPath = $request->file('gambar')->store('menu_images', 'public');

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
        $menu = Menu::findOrFail($id);
        $kategoriOptions = ['MANTUL', 'JAJANAN', 'SEGER', 'MANIS'];
        return view('admin.editmenu', compact('menu', 'kategoriOptions'));
    }

    // Memperbarui data menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'keterangan' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required|in:MANTUL,JAJANAN,SEGER,MANIS',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($menu->gambar) {
                \Storage::delete('public/' . $menu->gambar);
            }
            $gambarPath = $request->file('gambar')->store('menu_images', 'public');
            $menu->gambar = $gambarPath;
        }

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
        $menu = Menu::findOrFail($id);

        if ($menu->gambar) {
            \Storage::delete('public/' . $menu->gambar);
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    // Menampilkan form untuk menambah menu
    public function create()
    {
        $kategoriOptions = ['MANTUL', 'JAJANAN', 'SEGER', 'MANIS'];
        return view('admin.addmenu', compact('kategoriOptions'));
    }
}
