<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DendaController extends Controller
{
    /**
     * Tampilkan rekap denda untuk Admin
     */
    public function indexAdmin(Request $request)
    {
        $query = DetailTransaksi::with(['transaksi.anggota', 'buku'])
            ->where('status', 'dikembalikan')
            ->whereIn('status_denda', ['belum_lunas', 'lunas'])
            ->orderBy('tanggal_kembali', 'desc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('transaksi.anggota', function($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            })->orWhereHas('buku', function($sub) use ($search) {
                $sub->where('judul', 'like', "%{$search}%");
            });
        }
        
        $details = $query->paginate(20);

        // Calculate total
        $totalDendaKerusakan = DetailTransaksi::whereIn('status_denda', ['belum_lunas', 'lunas'])->sum('denda_kerusakan');
        $totalDendaKeterlambatan = DetailTransaksi::whereIn('status_denda', ['belum_lunas', 'lunas'])->sum('denda_keterlambatan');
        $totalKeseluruhan = $totalDendaKerusakan + $totalDendaKeterlambatan;

        return view('admin.denda.index', compact('details', 'totalKeseluruhan', 'totalDendaKerusakan', 'totalDendaKeterlambatan'));
    }

    /**
     * Tampilkan rekap denda untuk Siswa via Anggota guard
     */
    public function indexAnggota(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();
        
        // Ambil transaksi milik siswa yang sudah dikembalikan dan memiliki denda/denda kerusakan
        $transaksis = Transaksi::with(['detailTransaksi' => function($q) {
                $q->where('status', 'dikembalikan')
                  ->where('status_denda', 'lunas');
            }, 'detailTransaksi.buku'])
            ->where('anggota_id', $anggota->id)
            ->where('status', 'dikembalikan')
            ->whereHas('detailTransaksi', function($q) {
                $q->where('status_denda', 'lunas');
            })
            ->orderBy('tanggal_kembali', 'desc')
            ->get();

        $totalDenda = 0;
        $totalKerusakan = 0;
        foreach ($transaksis as $t) {
            foreach($t->detailTransaksi as $d) {
                $totalDenda += $d->denda_keterlambatan;
                $totalKerusakan += $d->denda_kerusakan;
            }
        }
        
        $totalSemua = $totalDenda + $totalKerusakan;

        return view('anggota.denda.index', compact('anggota', 'transaksis', 'totalDenda', 'totalKerusakan', 'totalSemua'));
    }

    /**
     * Tandai Denda sebagai Lunas (Admin)
     */
    public function lunasi(Request $request, DetailTransaksi $detail)
    {
        if ($detail->status_denda === 'lunas') {
            return back()->with('error', 'Denda ini sudah lunas sebelumnya.');
        }

        $detail->update(['status_denda' => 'lunas']);
        return back()->with('success', 'Denda untuk buku ' . $detail->buku->judul . ' berhasil ditandai Lunas!');
    }
}
