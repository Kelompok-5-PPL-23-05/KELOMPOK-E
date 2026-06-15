<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel pivot untuk relasi Many-to-Many antara Guru dan MataPelajaran
     */
    public function up(): void
    {
        Schema::create('guru_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('mapel_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('guru_id')
                  ->references('id_guru')
                  ->on('guru')
                  ->onDelete('cascade');

            $table->foreign('mapel_id')
                  ->references('id_mapel')
                  ->on('mata_pelajaran')
                  ->onDelete('cascade');

            // Unique constraint untuk mencegah duplikasi
            $table->unique(['guru_id', 'mapel_id'], 'guru_mapel_uk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_mata_pelajaran');
    }
};
