<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilais';

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'mata_pelajaran',
        'nilai',
        'catatan',
        'jenis_nilai',
    ];
}