<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'nilai_angka',
        'deskripsi',
        'Siswaid_siswa',
        'Guruid_guru',
        'Mata_Pelajaranid_mapel',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'Siswaid_siswa', 'id_siswa');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'Guruid_guru', 'id_guru');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'Mata_Pelajaranid_mapel', 'id_mapel');
    }
}
