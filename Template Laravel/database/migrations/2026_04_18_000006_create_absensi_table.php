<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel absensi - berelasi dengan siswa
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id_absensi');
            $table->integer('hadir')->default(0);   // jumlah hari hadir
            $table->integer('sakit')->default(0);   // jumlah hari sakit
            $table->integer('izin')->default(0);    // jumlah hari izin
            $table->integer('alfa')->default(0);    // jumlah hari alfa/tanpa keterangan
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
        Schema::dropIfExists('absensi');
    }
};
