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
    


    public function destroy(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = 'selesai';
        $pesanan->tanggal_selesai = Carbon::now();
        $pesanan->metode_pembayaran = $request->metode_pembayaran;

        if ($request->metode_pembayaran === 'Tunai') {
            $pesanan->nominal_bayar = $request->uang_tunai;
        } else {
            $totalHarga = $pesanan->detailPesanan->sum(fn($detail) => $detail->harga * $detail->jumlah);
            $pesanan->nominal_bayar = $totalHarga;
        }

        $pesanan->save();

        return redirect()->back()->with('success', 'Pesanan telah diselesaikan dengan pembayaran ' . $request->metode_pembayaran . '.');
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
                'tanggal_selesai' => $pesanan->updated_at, 
            ];
        });    

        return view('admin.orderhistory', compact('menus'));
    }

}
