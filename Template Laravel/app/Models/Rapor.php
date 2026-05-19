<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    use HasFactory;

    protected $table = 'rapor';
    protected $primaryKey = 'id_rapor';

    protected $fillable = [
        'nilai_akhir',
        'Siswaid_siswa',
        'file_path',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'Siswaid_siswa', 'id_siswa');
    }
}
