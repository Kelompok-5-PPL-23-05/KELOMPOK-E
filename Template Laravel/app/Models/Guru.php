<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'Userid_user',
        'nama_guru'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Userid_user', 'id_user');
    }

    /**
     * Relasi many-to-many dengan MataPelajaran
     * Mata pelajaran yang diampu oleh guru
     */
    public function mataPelajaran()
    {
        return $this->belongsToMany(
            MataPelajaran::class,
            'guru_mata_pelajaran',
            'guru_id',
            'mapel_id',
            'id_guru',
            'id_mapel'
        );
    }
}
