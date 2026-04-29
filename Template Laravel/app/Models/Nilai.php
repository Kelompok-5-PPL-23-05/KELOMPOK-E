<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    // Tabel: nilais (migration 2026_04_22_134513_create_nilais_table)
    protected $table    = 'nilais';
    protected $fillable = [
        'nama_siswa',
        'kelas',
        'mata_pelajaran',
        'nilai',
        'catatan',
    ];
}
