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
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('nomor_meja')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('nomor_meja')->nullable(false)->change();
        });
    }

};
