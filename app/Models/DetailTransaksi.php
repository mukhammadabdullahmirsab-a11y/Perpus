<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'buku_id',
        'jumlah',
        'tanggal_pengembalian',
        'tanggal_kembali',
        'status',
        'kondisi_buku',
        'denda_kerusakan',
        'denda_keterlambatan',
        'status_denda',
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'date',
        'tanggal_kembali' => 'date',
        'denda_kerusakan' => 'decimal:2',
        'denda_keterlambatan' => 'decimal:2',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Hitung denda keterlambatan per buku
     * Denda Rp1.000/hari setelah melewati tenggat
     */
    public function hitungDenda(): int
    {
        $dendaPerHari = 1000;

        $tanggalKembali = $this->tanggal_kembali ?? now();

        // Fallback ke transaksi-level tanggal_pengembalian, lalu tanggal_pinjam + 7 hari
        $tenggat = $this->tanggal_pengembalian
            ?? $this->transaksi->tanggal_pengembalian
            ?? $this->transaksi->tanggal_pinjam->addDays(7);

        $hariTerlambat = $tenggat->diffInDays($tanggalKembali, false);

        if ($hariTerlambat > 0) {
            return $hariTerlambat * $dendaPerHari;
        }

        return 0;
    }

    /**
     * Check if this detail is overdue
     */
    public function isTerlambat(): bool
    {
        if ($this->status === 'dikembalikan') {
            return false;
        }

        $tenggat = $this->tanggal_pengembalian
            ?? $this->transaksi->tanggal_pengembalian
            ?? $this->transaksi->tanggal_pinjam->addDays(7);

        return now()->gt($tenggat);
    }
}
