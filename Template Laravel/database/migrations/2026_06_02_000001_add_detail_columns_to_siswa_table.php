<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom detail peserta didik ke tabel siswa
     * untuk melengkapi halaman Keterangan Diri di rapor.
     */
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('nisn', 20)->nullable()->after('nama_siswa');
            $table->string('nis', 20)->nullable()->after('nisn');
            $table->string('tempat_lahir', 100)->nullable()->after('nis');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('tanggal_lahir');
            $table->string('agama', 50)->nullable()->after('jenis_kelamin');
            $table->integer('anak_ke')->nullable()->after('agama');
            $table->string('telepon', 20)->nullable()->after('anak_ke');
            $table->text('alamat')->nullable()->after('telepon');
            $table->string('nomor_gawai', 20)->nullable()->after('alamat');

            // Penerimaan di sekolah
            $table->date('tanggal_masuk')->nullable()->after('nomor_gawai');
            $table->string('kelas_masuk', 10)->nullable()->after('tanggal_masuk');
            $table->string('sebagai', 50)->nullable()->after('kelas_masuk'); // siswa baru / pindahan

            // Orang Tua
            $table->string('nama_ayah', 100)->nullable()->after('sebagai');
            $table->string('nama_ibu', 100)->nullable()->after('nama_ayah');
            $table->string('pekerjaan_ayah', 100)->nullable()->after('nama_ibu');
            $table->string('pekerjaan_ibu', 100)->nullable()->after('pekerjaan_ayah');

            // Wali
            $table->string('nama_wali', 100)->nullable()->after('pekerjaan_ibu');
            $table->string('pekerjaan_wali', 100)->nullable()->after('nama_wali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn([
                'nisn', 'nis', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
                'agama', 'anak_ke', 'telepon', 'alamat', 'nomor_gawai',
                'tanggal_masuk', 'kelas_masuk', 'sebagai',
                'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu',
                'nama_wali', 'pekerjaan_wali',
            ]);
        });
    }
};
