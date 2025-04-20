<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meja;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::all();
        return view('admin.viewmeja', compact('mejas'));
    }

    public function create()
    {
        return view('admin.addmeja');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|integer|unique:mejas,nomor_meja',
        ]);

        Meja::create([
            'nomor_meja' => $request->nomor_meja,
        ]);

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Meja::findOrFail($id)->delete();
        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus.');
    }

    // Fungsi untuk membuat QR Code
    public function generateQrCode($nomorMeja)
    {
        $url = route('guest.keranjang', ['nomor_meja' => $nomorMeja]); 
        return response(QrCode::size(200)->generate($url));
    }
}
