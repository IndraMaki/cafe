<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'nama',
        'keterangan',
        'harga',
        'kategori_id', // Menggunakan kategori_id sesuai dengan relasi
        'gambar',
    ];

    /**
     * Relasi ke tabel Kategori (satu menu memiliki satu kategori)
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
