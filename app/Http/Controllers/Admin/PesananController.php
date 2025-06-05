<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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

    
    public function history(Request $request)
    {
        $query = Pesanan::with('detailPesanan')
            ->where('status', 'selesai');

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('updated_at', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('updated_at', '<=', $request->tanggal_akhir);
        }

        $menus = $query->get()->map(function ($pesanan) {
            return (object)[
                'id' => $pesanan->id,
                'nama_makanan' => $pesanan->detailPesanan->pluck('nama_menu')->implode(', '),
                'nomor_meja' => $pesanan->nomor_meja,
                'nomor_hp' => $pesanan->nomor_hp,
                'harga' => $pesanan->detailPesanan->sum(function ($detail) {
                    return $detail->harga * $detail->jumlah;
                }),
                'tanggal_selesai' => $pesanan->updated_at,
                'metode_pembayaran' => $pesanan->metode_pembayaran,
                'detailPesanan' => $pesanan->detailPesanan, 
            ];
        });


        return view('admin.orderhistory', compact('menus'));
    }

    public function cetakStruk($id)
    {
        $pesanan = Pesanan::with('detailPesanan')->findOrFail($id);

        $data = [
            'pesanan' => $pesanan,
            'total' => $pesanan->detailPesanan->sum(fn($d) => $d->harga * $d->jumlah),
        ];

        return view('admin.struk', $data);
        // $pdf = Pdf::loadView('admin.struk', $data);
        // return $pdf->stream("Struk-{$pesanan->id}.pdf"); // bisa juga ->download()
    }

    public function detailPesananUser()
    {
    $nomor_hp = session('nomor_hp'); // Ambil dari session login

    if (!$nomor_hp) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
    }

    $pesanan = Pesanan::with('detailPesanan')
        ->where('nomor_hp', $nomor_hp)
        ->orderByDesc('created_at')
        ->get();

    return view('guest.detail-pesanan', compact('pesanan'));
    }


}
