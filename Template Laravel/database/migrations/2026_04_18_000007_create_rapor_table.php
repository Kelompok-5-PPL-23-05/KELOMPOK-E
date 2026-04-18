<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel rapor - berelasi dengan siswa, menyimpan nilai akhir rapor
     */
    public function up(): void
    {
        Schema::create('rapor', function (Blueprint $table) {
            $table->id('id_rapor');
            $table->integer('nilai_akhir');           // nilai akhir rapor
            $table->unsignedBigInteger('Siswaid_siswa'); // FK ke siswa.id_siswa
            $table->timestamps();

            $table->foreign('Siswaid_siswa')
                  ->references('id_siswa')
                  ->on('siswa')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapor');
    }
};
