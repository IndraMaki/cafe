<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    // Tambahkan kolom baru ke fillable supaya bisa diisi lewat mass assignment
    protected $fillable = [
        'nomor_hp',
        'status',
        'metode_pembayaran',
        'nominal_bayar',
        'tanggal_selesai',
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
