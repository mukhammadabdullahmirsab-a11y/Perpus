<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $fillable = ['nama_rak', 'lokasi'];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }
}
