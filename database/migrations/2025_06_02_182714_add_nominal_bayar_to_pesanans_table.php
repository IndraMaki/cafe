<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek dulu apakah kolom 'nominal_bayar' sudah ada
        if (!Schema::hasColumn('pesanans', 'nominal_bayar')) {
            Schema::table('pesanans', function (Blueprint $table) {
                $table->bigInteger('nominal_bayar')->nullable()->after('metode_pembayaran')->comment('Nominal uang yang dibayarkan pelanggan');
            });
        }

        // Cek dulu apakah kolom 'tanggal_selesai' sudah ada
        if (!Schema::hasColumn('pesanans', 'tanggal_selesai')) {
            Schema::table('pesanans', function (Blueprint $table) {
                $table->timestamp('tanggal_selesai')->nullable()->after('nominal_bayar')->comment('Tanggal transaksi selesai');
            });
        }

        // Cek dulu apakah kolom 'metode_pembayaran' sudah ada
        if (!Schema::hasColumn('pesanans', 'metode_pembayaran')) {
            Schema::table('pesanans', function (Blueprint $table) {
                $table->string('metode_pembayaran')->nullable()->after('status')->comment('Metode pembayaran pelanggan');
            });
        }
    }

    public function down(): void
    {
        // Hapus kolom hanya jika ada (agar rollback aman)
        Schema::table('pesanans', function (Blueprint $table) {
            if (Schema::hasColumn('pesanans', 'nominal_bayar')) {
                $table->dropColumn('nominal_bayar');
            }
            if (Schema::hasColumn('pesanans', 'tanggal_selesai')) {
                $table->dropColumn('tanggal_selesai');
            }
            if (Schema::hasColumn('pesanans', 'metode_pembayaran')) {
                $table->dropColumn('metode_pembayaran');
            }
        });
    }
};
