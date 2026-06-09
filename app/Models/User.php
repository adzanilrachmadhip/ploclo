<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'nama_lengkap',
        'nip',
        'nidn',
        'kode_dosen',
        'role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return strtolower($this->role) === 'admin';
    }

    public function isKaprodi(): bool
    {
        return strtolower($this->role) === 'kaprodi';
    }

    public function isDosenWali(): bool
    {
        return in_array(strtolower($this->role), ['dosen wali', 'dosen_wali', 'dosenwali', 'dosen-wali']);
    }
}
