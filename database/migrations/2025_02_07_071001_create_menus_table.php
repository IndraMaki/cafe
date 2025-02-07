<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama menu
            $table->text('keterangan'); // Keterangan menu
            $table->decimal('harga', 10, 2); // Harga menu
            $table->enum('kategori', ['MANTUL', 'JAJANAN', 'SEGER', 'MANIS']); // Kategori menu
            $table->string('gambar'); // Path gambar menu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
