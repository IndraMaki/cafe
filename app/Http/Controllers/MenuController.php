<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;
use App\Models\Kategori;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar menu di halaman admin.
     */
    public function index()
    {
        $menus = Menu::with('kategori')->get();
        return view('admin.menu', compact('menus'));
    }

    /**
     * Menampilkan daftar menu untuk pengguna di halaman user.
     */
    public function userIndex()
    {
        $menus = Menu::with('kategori')->get();
        return view('user.index', compact('menus'));
    }

    /**
     * Menampilkan form untuk menambah menu.
     */
    public function create()
    {
        $kategoriOptions = Kategori::pluck('nama', 'id'); // Mengambil kategori dalam format id => nama
        return view('admin.addmenu', compact('kategoriOptions'));
    }

    /**
     * Menyimpan data menu baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'keterangan'  => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategori,id', // Pastikan tabelnya sesuai dengan migration
            'gambar'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan gambar
        $gambarPath = $request->file('gambar')->store('menu_images', 'public');

        // Simpan data menu
        Menu::create([
            'nama'        => $request->nama,
            'keterangan'  => $request->keterangan,
            'harga'       => $request->harga,
            'kategori_id' => $request->kategori_id,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit menu.
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $kategoriOptions = Kategori::pluck('nama', 'id'); // Ambil kategori untuk dropdown
        return view('admin.editmenu', compact('menu', 'kategoriOptions'));
    }

    /**
     * Memperbarui data menu.
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama'        => 'required|string|max:255',
            'keterangan'  => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika ada gambar baru, hapus yang lama dan simpan yang baru
        if ($request->hasFile('gambar')) {
            if ($menu->gambar) {
                Storage::delete('public/' . $menu->gambar);
            }
            $gambarPath = $request->file('gambar')->store('menu_images', 'public');
            $menu->gambar = $gambarPath;
        }

        // Update data menu
        $menu->update([
            'nama'        => $request->nama,
            'keterangan'  => $request->keterangan,
            'harga'       => $request->harga,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Menghapus data menu.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus gambar jika ada
        if ($menu->gambar) {
            Storage::delete('public/' . $menu->gambar);
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
