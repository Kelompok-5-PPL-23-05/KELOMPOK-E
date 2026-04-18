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
}
