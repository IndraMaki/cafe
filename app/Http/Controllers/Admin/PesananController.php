<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan 'pending' beserta relasi detailnya
        $menus = Pesanan::with('detailPesanan')
            ->where('status', 'pending')
            ->get();
    
        return view('admin.pesananonproses', compact('menus'));
    }
    



    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = 'selesai';
        $pesanan->tanggal_selesai = Carbon::now(); // Menyimpan waktu sekarang
        $pesanan->save();
    
        return redirect()->back()->with('success', 'Pesanan telah diselesaikan.');
    }
    
    public function history()
    {
        $menus = Pesanan::with('detailPesanan')
        ->where('status', 'selesai')
        ->get()
        ->map(function ($pesanan) {
            return (object)[
                'id' => $pesanan->id,
                'nama_makanan' => $pesanan->detailPesanan->pluck('nama_menu')->implode(', '),
                'nomor_meja' => $pesanan->nomor_meja,
                'nomor_hp' => $pesanan->nomor_hp,
                'harga' => $pesanan->detailPesanan->sum(function ($detail) {
                    return $detail->harga * $detail->jumlah;
                }),
                'tanggal_selesai' => $pesanan->updated_at, // Misalnya pakai updated_at
            ];
        });    

        return view('admin.orderhistory', compact('menus'));
    }

}
