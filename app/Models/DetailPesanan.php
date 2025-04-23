<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = ['pesanan_id', 'nama_menu', 'harga', 'jumlah'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
