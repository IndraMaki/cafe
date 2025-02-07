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
        'kategori',
        'gambar',
    ];

    // Daftar kategori yang diperbolehkan
    public static function getKategoriOptions()
    {
        return ['MANTUL', 'JAJANAN', 'SEGER', 'MANIS'];
    }
}
