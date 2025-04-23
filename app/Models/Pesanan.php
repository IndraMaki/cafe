<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = ['nomor_meja', 'nomor_hp', 'status'];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}

