<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable
{
    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
