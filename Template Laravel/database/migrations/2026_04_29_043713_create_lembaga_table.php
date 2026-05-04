<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lembaga', function (Blueprint $table) {
            if (!Schema::hasColumn('lembaga', 'no_telepon')) {
                $table->string('no_telepon', 20)->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('lembaga', 'email')) {
                $table->string('email', 255)->nullable()->after('no_telepon');
            }
            if (!Schema::hasColumn('lembaga', 'kepala_lembaga')) {
                $table->string('kepala_lembaga', 255)->nullable()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('lembaga', function (Blueprint $table) {
            $table->dropColumn(['no_telepon', 'email', 'kepala_lembaga']);
        });
    }
};