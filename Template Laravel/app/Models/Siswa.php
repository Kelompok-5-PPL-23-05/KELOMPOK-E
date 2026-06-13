<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    // Eager loading relasi secara otomatis (Subtask 1)
    protected $with = ['nilai', 'absensi'];

    protected $fillable = [
        'nama_siswa', 'Kelasid_kelas',
        'nisn', 'nis',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama',
        'anak_ke', 'telepon', 'alamat', 'nomor_gawai',
        'tanggal_masuk', 'kelas_masuk', 'sebagai',
        'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu',
        'nama_wali', 'pekerjaan_wali',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'tanggal_masuk'  => 'date',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'Kelasid_kelas', 'id_kelas');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'Siswaid_siswa', 'id_siswa');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'Siswaid_siswa', 'id_siswa');
    }

    public function rapor()
    {
        return $this->hasMany(Rapor::class, 'Siswaid_siswa', 'id_siswa');
    }
}
