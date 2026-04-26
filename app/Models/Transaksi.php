<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'anggota_id',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'tanggal_kembali',
        'status',
        'denda',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_pengembalian' => 'date',
        'tanggal_kembali' => 'date',
        'denda' => 'decimal:2',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    /**
     * Detail buku dalam transaksi ini
     */
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    /**
     * Shortcut: ambil buku pertama (backward compatibility)
     */
    public function buku()
    {
        // Untuk kompatibilitas — akses buku pertama via detail
        return $this->hasOneThrough(
            Buku::class,
            DetailTransaksi::class,
            'transaksi_id', // FK on detail_transaksi
            'id',           // PK on bukus
            'id',           // PK on transaksis
            'buku_id'       // FK on detail_transaksi
        );
    }

    /**
     * Hitung total denda keterlambatan dari semua detail
     */
    public function hitungDenda(): int
    {
        $total = 0;
        foreach ($this->detailTransaksi as $detail) {
            $total += $detail->hitungDenda();
        }
        return $total;
    }

    /**
     * Check if any detail is overdue
     */
    public function isTerlambat(): bool
    {
        if ($this->status === 'dikembalikan') {
            return $this->denda > 0;
        }

        foreach ($this->detailTransaksi as $detail) {
            if ($detail->isTerlambat()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Total denda kerusakan dari semua detail
     */
    public function totalDendaKerusakan(): int
    {
        return (int) $this->detailTransaksi->sum('denda_kerusakan');
    }

    /**
     * Total jumlah buku dalam transaksi
     */
    public function jumlahBuku(): int
    {
        return (int) $this->detailTransaksi->sum('jumlah');
    }

    /**
     * Check if all details have been returned
     */
    public function semuaDikembalikan(): bool
    {
        if ($this->detailTransaksi->isEmpty()) {
            return false;
        }
        return $this->detailTransaksi->every(fn($d) => $d->status === 'dikembalikan');
    }

    /**
     * Count returned details
     */
    public function jumlahDikembalikan(): int
    {
        return $this->detailTransaksi->where('status', 'dikembalikan')->count();
    }

    /**
     * Total denda (keterlambatan + kerusakan) dari semua detail
     */
    public function totalSemuaDenda(): int
    {
        return $this->hitungDenda() + $this->totalDendaKerusakan();
    }
}
