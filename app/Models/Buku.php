<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Buku extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'stok',
        'deskripsi',
        'cover_image',
        'kategori_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Akses rak melalui kategori.
     */
    public function rak(): HasOneThrough
    {
        return $this->hasOneThrough(
            Rak::class,
            Kategori::class,
            'id',          // kategoris.id
            'id',          // raks.id
            'kategori_id', // bukus.kategori_id
            'rak_id'       // kategoris.rak_id
        );
    }
}
