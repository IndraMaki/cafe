<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pesanans', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_meja');
        $table->string('nomor_hp')->nullable();
        $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
