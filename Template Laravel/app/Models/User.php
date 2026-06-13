<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // /**
    //  * Gunakan 'username' sebagai field autentikasi (bukan email)
    //  * Ini dipakai oleh Auth::attempt() untuk mencari user di DB
    //  */
    // public function getAuthIdentifierName(): string
    // {
    //     return 'username';
    // }

    public function getAuthIdentifier()
    {
        return $this->id_user;
    }

    /**
     * Gunakan 'username' sebagai field untuk Auth::attempt()
     */
    public function getAuthPassword(): string
    {
        return $this->password;
    }


    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Guru
     */
    public function guru()
    {
        return $this->hasOne(Guru::class, 'Userid_user', 'id_user');
    }
}
