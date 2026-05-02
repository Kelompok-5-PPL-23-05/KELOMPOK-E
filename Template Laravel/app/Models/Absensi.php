<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table      = 'absensi';
    protected $primaryKey = 'id_absensi';

    protected $fillable = [
        'hadir',
        'sakit',
        'izin',
        'alfa',
        'Siswaid_siswa',
    ];

    /**
     * Relasi ke Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'Siswaid_siswa', 'id_siswa');
    }

    /**
     * Total hari yang tercatat
     */
    public function getTotalHariAttribute(): int
    {
        return $this->hadir + $this->sakit + $this->izin + $this->alfa;
    }
}
