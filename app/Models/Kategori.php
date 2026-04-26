<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori', 'rak_id'];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }
}
