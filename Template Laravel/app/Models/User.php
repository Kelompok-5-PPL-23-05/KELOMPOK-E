<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    /**
     * Beritahu Laravel bahwa primary key bukan 'id' default
     * Ini WAJIB agar middleware 'auth' bisa mengenali user dari session
     */
    public function getAuthIdentifierName(): string
    {
        return 'id_user';
    }

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
