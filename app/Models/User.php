<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;


/**
 * @property string|null $role
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_pegawai',
        'nama',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Gunakan id sebagai identifier default untuk autentikasi.
     * (Sebenarnya ini default Laravel, tapi tidak salah jika eksplisit.)
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }
}
