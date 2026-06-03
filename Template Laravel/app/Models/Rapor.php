<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    protected $table = 'rapor';
    protected $primaryKey = 'id_rapor';

    protected $fillable = [
        'Siswaid_siswa',
        'mata_pelajaran',
        'nilai_akhir',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'Siswaid_siswa', 'id_siswa');
    }
}