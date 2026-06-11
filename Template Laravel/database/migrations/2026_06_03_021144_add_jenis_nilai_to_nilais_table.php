<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->enum('jenis_nilai', ['UTS', 'UAS', 'Tugas'])
                  ->default('Tugas')
                  ->after('nilai_angka');
        });
    }

    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropColumn('jenis_nilai');
        });
    }
};