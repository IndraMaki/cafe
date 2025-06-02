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
        Schema::table('pesanans', function (Blueprint $table) {
            // Tambahkan kolom nominal_bayar setelah kolom status
            $table->bigInteger('nominal_bayar')->nullable()->after('status');

            // Tambahkan kolom tanggal_selesai setelah nominal_bayar
            $table->timestamp('tanggal_selesai')->nullable()->after('nominal_bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Hanya drop kolom yang ditambahkan di up()
            $table->dropColumn(['nominal_bayar', 'tanggal_selesai']);
        });
    }
};
