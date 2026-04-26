<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Buku;
use App\Models\Kategori;

class ResetKategoriBuku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-kategori-buku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai konversi Kategori Buku...');

        // 1. Dapatkan atau Buat Kategori "Buku Pelajaran"
        $katPelajaran = Kategori::firstOrCreate(['nama_kategori' => 'Buku Pelajaran']);
        
        // 2. Dapatkan atau Buat Kategori "Novel"
        $katNovel = Kategori::firstOrCreate(['nama_kategori' => 'Novel']);

        $kategoriIds = [$katPelajaran->id, $katNovel->id];

        // 3. Ambil Semua Buku dan Distribusikan Acak
        $bukus = Buku::all();
        $count = 0;

        foreach ($bukus as $buku) {
            // Assign secara random (50:50 probability)
            $buku->kategori_id = $kategoriIds[array_rand($kategoriIds)];
            $buku->save();
            $count++;
        }

        // 4. Hapus kategori lain yang tersisa di database selain 2 di atas
        $deleted = Kategori::whereNotIn('id', $kategoriIds)->delete();

        $this->info("Berhasil! $count buku sekarang telah dikelompokkan. $deleted Kategori usang berhasil dihapus.");
    }
}
