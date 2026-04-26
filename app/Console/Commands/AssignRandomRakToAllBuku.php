<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Buku;
use App\Models\Rak;

class AssignRandomRakToAllBuku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-random-rak-to-all-buku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Provide assign random rak_id to all books';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $raks = Rak::all();
        
        if ($raks->isEmpty()) {
            $this->error('Tidak ada data rak di database. Harap buat rak terlebih dahulu.');
            return;
        }

        $bukus = Buku::all();
        $count = 0;

        foreach ($bukus as $buku) {
            $randomRak = $raks->random();
            $buku->rak_id = $randomRak->id;
            $buku->save();
            $count++;
        }

        $this->info("Berhasil mengassign lokasi Rak secara acak kepada $count buah buku.");
    }
}
