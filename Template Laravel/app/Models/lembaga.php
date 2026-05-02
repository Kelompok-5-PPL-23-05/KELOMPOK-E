<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    protected $table = 'lembaga';
    protected $primaryKey = 'id_lembaga';
    protected $fillable = ['nama_lembaga', 'alamat', 'kontak'];
}
