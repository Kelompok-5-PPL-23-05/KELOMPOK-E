<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel nilai - berelasi dengan siswa, guru, dan mata_pelajaran
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->integer('nilai_angka');           // nilai dalam angka
            $table->string('deskripsi', 255)->nullable(); // deskripsi/catatan nilai
            $table->integer('Column')->nullable();     // kolom tambahan sesuai ERD
            $table->unsignedBigInteger('Siswaid_siswa');      // FK ke siswa.id_siswa
            $table->unsignedBigInteger('Guruid_guru');         // FK ke guru.id_guru
            $table->unsignedBigInteger('Mata_Pelajaranid_mapel'); // FK ke mata_pelajaran.id_mapel
            $table->timestamps();

            $table->foreign('Siswaid_siswa')
                  ->references('id_siswa')
                  ->on('siswa')
                  ->onDelete('cascade');

            $table->foreign('Guruid_guru')
                  ->references('id_guru')
                  ->on('guru')
                  ->onDelete('cascade');

            $table->foreign('Mata_Pelajaranid_mapel')
                  ->references('id_mapel')
                  ->on('mata_pelajaran')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
