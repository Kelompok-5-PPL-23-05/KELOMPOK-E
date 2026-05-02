<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mapel';

    protected $fillable = ['nama_mapel'];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'Mata_Pelajaranid_mapel', 'id_mapel');
    }

    /**
     * Relasi many-to-many dengan Guru
     */
    public function guru()
    {
        return $this->belongsToMany(
            Guru::class,
            'guru_mata_pelajaran',
            'mapel_id',
            'guru_id',
            'id_mapel',
            'id_guru'
        );
    }
}
