<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lembaga', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lembaga', 255);
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->string('email', 255);
            $table->string('kepala_lembaga', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lembaga');
    }
};