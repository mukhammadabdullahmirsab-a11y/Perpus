<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$transaksis = \App\Models\Transaksi::where('denda', '>', 0)->get();
foreach ($transaksis as $trx) {
    // Cari detail yang mungkin belum punya denda_keterlambatan
    foreach($trx->detailTransaksi as $detail) {
        if ($detail->status == 'dikembalikan') {
            // Kita bagi rata atau berikan ke satu detail saja
            // Disini, taruh denda di detail pertama saja untuk data lama
            $detail->update([
                'denda_keterlambatan' => $trx->denda,
                'status_denda' => 'belum_lunas'
            ]);
            break;
        }
    }
}

// Update juga denda kerusakan
$details_kerusakan = \App\Models\DetailTransaksi::where('denda_kerusakan', '>', 0)->get();
foreach ($details_kerusakan as $detail) {
    $detail->update([
        'status_denda' => 'belum_lunas'
    ]);
}

echo "Database sync complete.\n";
