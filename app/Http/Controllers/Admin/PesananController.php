<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan dengan status 'pending' (atau sesuai kebutuhan)
        $menus = Pesanan::with('detailPesanan')
            ->where('status', 'pending')
            ->get()
            ->map(function ($pesanan) {
                return (object)[
                    'id' => $pesanan->id,
                    'nomor_hp' => $pesanan->nomor_hp,
                    'nomor_meja' => $pesanan->nomor_meja,
                    'harga' => $pesanan->detailPesanan->sum(function ($detail) {
                        return $detail->harga * $detail->jumlah;
                    }),
                ];
            });

        return view('admin.pesananonproses', compact('menus'));
    }

    public function destroy($id)
    {
        // Update status pesanan menjadi selesai
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = 'selesai';
        $pesanan->save();

        return redirect()->back()->with('success', 'Pesanan telah diselesaikan.');
    }
}
