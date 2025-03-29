<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mejas', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_meja')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mejas');
    }
};
