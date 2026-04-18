<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = ['nama_siswa', 'Kelasid_kelas'];

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
