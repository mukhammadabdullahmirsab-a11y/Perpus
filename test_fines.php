<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$details = \App\Models\DetailTransaksi::where('status', 'dikembalikan')->get(['id', 'transaksi_id', 'status', 'denda_kerusakan', 'denda_keterlambatan', 'status_denda']);
echo json_encode($details->toArray(), JSON_PRETTY_PRINT);
