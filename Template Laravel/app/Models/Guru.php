<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id_guru';
    public $timestamps = false; // Add if no timestamps in table

    protected $fillable = [
        'Userid_user',
        'nama_guru'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Userid_user', 'id_user');
    }
}
