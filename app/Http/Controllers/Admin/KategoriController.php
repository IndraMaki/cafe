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

    // **Hapus kategori**
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Hapus logo jika ada
        if ($kategori->logo) {
            Storage::disk('public')->delete($kategori->logo);
        }

        $kategori->delete();
        return redirect()->route('admin.viewkategori')->with('success', 'Kategori berhasil dihapus.');
    }
    // Tampilkan form edit
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.editkategori', compact('kategori'));
    }

// Simpan perubahan kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $kategori = Kategori::findOrFail($id);

        // Kalau ada upload logo baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($kategori->logo) {
                Storage::disk('public')->delete($kategori->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $kategori->logo = $logoPath;
        }

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->route('admin.viewkategori')->with('success', 'Kategori berhasil diperbarui.');
    }

}
