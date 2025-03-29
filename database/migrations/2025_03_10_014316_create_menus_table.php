<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_makanan'); // Nama makanan
            $table->text('deskripsi'); // Deskripsi makanan
            $table->decimal('harga', 10, 2); // Harga dengan 2 angka desimal
            $table->unsignedBigInteger('kategori_id'); // Foreign key ke kategori
            $table->string('gambar')->nullable(); // Gambar makanan (opsional)
            $table->timestamps();

            // Foreign key untuk kategori
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
