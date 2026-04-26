<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Show report filter form
     */
    public function index()
    {
        return view('admin.laporan.index');
    }

    /**
     * Generate printable report
     */
    public function cetak(Request $request)
    {
        $validated = $request->validate([
            'filter_otomatis' => 'nullable|string',
            'dari_tanggal' => 'nullable|date',
            'sampai_tanggal' => 'nullable|date|after_or_equal:dari_tanggal',
            'status' => 'nullable|in:dipinjam,dikembalikan',
        ]);

        // Override Tanggal berdasarkan Filter Otomatis
        $dariTanggal = now()->startOfMonth()->format('Y-m-d');
        $sampaiTanggal = now()->format('Y-m-d');

        if (!empty($validated['filter_otomatis']) && $validated['filter_otomatis'] !== 'custom') {
            if ($validated['filter_otomatis'] === '1_hari') {
                $dariTanggal = now()->format('Y-m-d');
                $sampaiTanggal = now()->format('Y-m-d');
            } elseif ($validated['filter_otomatis'] === '1_minggu') {
                $dariTanggal = now()->startOfWeek()->format('Y-m-d');
                $sampaiTanggal = now()->endOfWeek()->format('Y-m-d');
            } elseif ($validated['filter_otomatis'] === '1_bulan') {
                $dariTanggal = now()->startOfMonth()->format('Y-m-d');
                $sampaiTanggal = now()->endOfMonth()->format('Y-m-d');
            }
        } else {
            // Gunakan rentang manual jika custom
            $dariTanggal = $validated['dari_tanggal'] ?? $dariTanggal;
            $sampaiTanggal = $validated['sampai_tanggal'] ?? $sampaiTanggal;
        }

        $query = Transaksi::with(['anggota', 'detailTransaksi.buku'])
            ->whereBetween('tanggal_pinjam', [$dariTanggal, $sampaiTanggal]);

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $transaksis = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $totalDenda = $transaksis->sum(function ($transaksi) {
            // Untuk buku yang masih dipinjam, hitung denda secara dinamis
            if ($transaksi->status === 'dipinjam') {
                return $transaksi->hitungDenda();
            }
            // Untuk buku yang sudah dikembalikan, gunakan denda yang tersimpan di DB
            return $transaksi->denda;
        });
        $totalDipinjam = $transaksis->where('status', 'dipinjam')->count();
        $totalDikembalikan = $transaksis->where('status', 'dikembalikan')->count();

        // Custom format untuk dikirim ke view
        $validated['dari_tanggal'] = $dariTanggal;
        $validated['sampai_tanggal'] = $sampaiTanggal;

        $pdf = Pdf::loadView('admin.laporan.cetak', compact(
            'transaksis', 'totalDenda', 'totalDipinjam', 'totalDikembalikan', 'validated'
        ))->setPaper('a4', 'landscape');

        $filename = 'Laporan_Peminjaman_' . $dariTanggal . '_sd_' . $sampaiTanggal . '.pdf';

        // Mode download: langsung download PDF
        if ($request->has('download')) {
            return $pdf->download($filename);
        }

        // Mode stream: tampilkan PDF inline di iframe
        if ($request->has('stream')) {
            return $pdf->stream($filename);
        }

        // Mode preview: tampilkan halaman preview wrapper
        $queryParams = $request->only(['filter_otomatis', 'dari_tanggal', 'sampai_tanggal', 'status']);
        return view('components.preview-pdf', [
            'title' => 'Laporan Peminjaman',
            'streamUrl' => route('laporan.cetak', array_merge($queryParams, ['stream' => 1])),
            'downloadUrl' => route('laporan.cetak', array_merge($queryParams, ['download' => 1])),
            'backUrl' => route('laporan.index'),
        ]);
    }
}
