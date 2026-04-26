<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun' => 2005,
                'stok' => 15,
            ],
            [
                'judul' => 'Bumi',
                'penulis' => 'Tere Liye',
                'penerbit' => 'Gramedia Pustaka Utama',
                'tahun' => 2014,
                'stok' => 20,
            ],
            [
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'penerbit' => 'Penerbit Buku Kompas',
                'tahun' => 2018,
                'stok' => 10,
            ],
            [
                'judul' => 'Harry Potter and the Philosopher\'s Stone',
                'penulis' => 'J.K. Rowling',
                'penerbit' => 'Bloomsbury',
                'tahun' => 1997,
                'stok' => 5,
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'penerbit' => 'Penguin Random House',
                'tahun' => 2018,
                'stok' => 25,
            ],
        ];

        foreach ($books as $book) {
            \App\Models\Buku::updateOrCreate(['judul' => $book['judul']], $book);
        }
    }
}
