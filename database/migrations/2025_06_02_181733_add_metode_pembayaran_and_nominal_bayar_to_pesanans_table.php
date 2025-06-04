<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Hanya tambahkan kolom yang belum ada
            $table->string('metode_pembayaran')->nullable()->after('status');

            // JANGAN tambahkan nominal_bayar dan tanggal_selesai karena sudah ada sebelumnya
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
        });
    }
};
