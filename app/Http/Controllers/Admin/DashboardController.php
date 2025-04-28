<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Meja;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $today = Carbon::today();

        $pendapatanHarian = Pesanan::where('status', 'selesai')
            ->whereDate('updated_at', $today)
            ->with('detailPesanan')
            ->get()
            ->sum(function ($pesanan) {
                return $pesanan->detailPesanan->sum(function ($detail) {
                    return $detail->harga * $detail->jumlah;
                });
            });

        $totalMeja = Meja::count();

        $totalPengunjung = Pesanan::where('status', 'selesai')
            ->whereDate('updated_at', $today)
            ->count();

        // Data untuk chart 30 hari terakhir
        $startDate = Carbon::now()->subDays(29); // 30 hari terakhir
        $endDate = Carbon::now();

        $dates = [];
        $pendapatan = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $tanggal = $date->toDateString();

            $total = Pesanan::where('status', 'selesai')
                ->whereDate('updated_at', $tanggal)
                ->with('detailPesanan')
                ->get()
                ->sum(function ($pesanan) {
                    return $pesanan->detailPesanan->sum(function ($detail) {
                        return $detail->harga * $detail->jumlah;
                    });
                });

            $dates[] = $tanggal;
            $pendapatan[] = $total;
        }

        return view('admin.dashboard', [
            'admin' => $admin,
            'pendapatanHarian' => $pendapatanHarian,
            'totalMeja' => $totalMeja,
            'totalPengunjung' => $totalPengunjung,
            'dates' => $dates,
            'pendapatan' => $pendapatan,
        ]);
    }
}
