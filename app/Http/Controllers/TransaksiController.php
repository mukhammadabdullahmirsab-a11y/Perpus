<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['anggota', 'detailTransaksi.buku']);
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('anggota', function($sub) use ($search) {
                    $sub->where('nama', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                })->orWhereHas('detailTransaksi.buku', function($sub) use ($search) {
                    $sub->where('judul', 'like', "%{$search}%");
                });
            });
        }
        
        $transaksis = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.transaksi.index', compact('transaksis'));
    }


    /**
     * Menampilkan daftar transaksi khusus untuk persetujuan (menunggu) dan pengembalian (dipinjam).
     */
    public function approval(Request $request)
    {
        $query = Transaksi::with(['anggota', 'detailTransaksi.buku'])->whereIn('status', ['menunggu', 'dipinjam']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('anggota', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', "%{$search}%")
                         ->orWhere('nis', 'like', "%{$search}%");
                })->orWhereHas('detailTransaksi.buku', function($subQ) use ($search) {
                    $subQ->where('judul', 'like', "%{$search}%");
                });
            });
        }

        $transaksis = $query->orderBy('created_at', 'desc')->get();
        return view('admin.transaksi.approval', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggotas = Anggota::orderBy('nama')->get();
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();
        
        return view('admin.transaksi.create', compact('anggotas', 'bukus'));
    }

    /**
     * Store a newly created resource in storage (Admin directly borrowing for user).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|array|min:1',
            'buku_id.*' => 'required|exists:bukus,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:menunggu,dipinjam,dikembalikan,ditolak',
        ]);
        
        // Check stock for all books if status is 'dipinjam'
        if ($validated['status'] === 'dipinjam') {
            for ($i = 0; $i < count($validated['buku_id']); $i++) {
                $buku = Buku::find($validated['buku_id'][$i]);
                $jumlah = $validated['jumlah'][$i];
                if ($buku->stok < $jumlah) {
                    return back()->with('error', "Stok buku \"{$buku->judul}\" tidak mencukupi! (Stok: {$buku->stok}, Diminta: {$jumlah})")->withInput();
                }
            }
        }
        
        // Default tanggal_pengembalian = tanggal_pinjam + 7 hari
        $tanggalPengembalian = $validated['tanggal_pengembalian'] 
            ?? date('Y-m-d', strtotime($validated['tanggal_pinjam'] . ' +7 days'));
        
        $transaksi = Transaksi::create([
            'anggota_id' => $validated['anggota_id'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_pengembalian' => $tanggalPengembalian,
            'tanggal_kembali' => $validated['status'] === 'dikembalikan' ? now() : null,
            'status' => $validated['status'],
        ]);

        // Create detail transaksi for each book
        for ($i = 0; $i < count($validated['buku_id']); $i++) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'buku_id' => $validated['buku_id'][$i],
                'jumlah' => $validated['jumlah'][$i],
            ]);

            if ($validated['status'] === 'dipinjam') {
                Buku::find($validated['buku_id'][$i])->decrement('stok', $validated['jumlah'][$i]);
            }
        }
        
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksi.buku');
        $anggotas = Anggota::orderBy('nama')->get();
        $bukus = Buku::orderBy('judul')->get();
        
        return view('admin.transaksi.edit', compact('transaksi', 'anggotas', 'bukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_pengembalian' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required|in:menunggu,dipinjam,dikembalikan,ditolak',
        ]);
        
        $oldStatus = $transaksi->status;
        $newStatus = $validated['status'];
        
        $transaksi->load('detailTransaksi.buku');
        
        // Handle stock changes based on status transition
        if ($newStatus === 'dipinjam' && $oldStatus !== 'dipinjam') {
            // Check stock for all books
            foreach ($transaksi->detailTransaksi as $detail) {
                if ($detail->buku->stok < $detail->jumlah) {
                    return back()->with('error', "Stok buku \"{$detail->buku->judul}\" tidak mencukupi!")->withInput();
                }
            }
            // Decrement stock
            foreach ($transaksi->detailTransaksi as $detail) {
                $detail->buku->decrement('stok', $detail->jumlah);
            }
            $validated['tanggal_kembali'] = null;
        } elseif ($oldStatus === 'dipinjam' && $newStatus !== 'dipinjam') {
            // Restore stock
            foreach ($transaksi->detailTransaksi as $detail) {
                $detail->buku->increment('stok', $detail->jumlah);
            }
            if ($newStatus === 'dikembalikan') {
                $validated['tanggal_kembali'] = $validated['tanggal_kembali'] ?? now();
            }
        }
        
        $transaksi->update($validated);
        
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksi.buku');
        
        // If currently borrowed, restore stock
        if ($transaksi->status == 'dipinjam') {
            foreach ($transaksi->detailTransaksi as $detail) {
                $detail->buku->increment('stok', $detail->jumlah);
            }
        }
        
        $transaksi->delete();
        
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    /**
     * Approve Peminjaman
     */
    public function approve(Transaksi $transaksi)
    {
        if ($transaksi->status !== 'menunggu') {
            return back()->with('error', 'Status transaksi ini tidak bisa disetujui.');
        }

        $transaksi->load('detailTransaksi.buku');

        // Check stock for all books
        foreach ($transaksi->detailTransaksi as $detail) {
            if ($detail->buku->stok < $detail->jumlah) {
                return back()->with('error', "Stok buku \"{$detail->buku->judul}\" tidak mencukupi!");
            }
        }

        $transaksi->update(['status' => 'dipinjam']);
        
        foreach ($transaksi->detailTransaksi as $detail) {
            // Update individual detail status
            $detail->update(['status' => 'dipinjam']);
            $detail->buku->decrement('stok', $detail->jumlah);
        }

        return back()->with('success', 'Peminjaman disetujui. Stok buku berhasil dikurangi.');
    }

    /**
     * Reject Peminjaman
     */
    public function reject(Transaksi $transaksi)
    {
        if ($transaksi->status !== 'menunggu') {
            return back()->with('error', 'Status transaksi ini tidak bisa ditolak.');
        }

        $transaksi->update(['status' => 'ditolak']);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }
    
    /**
     * Quick return book
     */
    public function kembalikanDetail(Request $request, DetailTransaksi $detail)
    {
        if ($detail->status == 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan sebelumnya.');
        }
        
        $detail->load(['transaksi', 'buku']);
        $transaksi = $detail->transaksi;
        
        // Handle return values from request (for damaged/lost books if implemented)
        $kondisi = $request->input('kondisi_buku', 'baik');
        $dendaKerusakan = $request->input('denda_kerusakan', 0);
        
        // Calculate late fee for this detail
        $dendaKeterlambatan = $detail->hitungDenda();
        
        $statusDenda = ($dendaKeterlambatan + $dendaKerusakan) > 0 ? 'belum_lunas' : 'bebas_denda';
        
        $detail->update([
            'tanggal_kembali' => now(),
            'status' => 'dikembalikan',
            'kondisi_buku' => $kondisi,
            'denda_kerusakan' => $dendaKerusakan,
            'denda_keterlambatan' => $dendaKeterlambatan,
            'status_denda' => $statusDenda,
        ]);
        
        // Restore stock for this book depending on condition
        if ($kondisi !== 'hilang') {
            $detail->buku->increment('stok', $detail->jumlah);
        }
        
        // Add fees to transaction
        $totalDendaDetail = $dendaKeterlambatan + $dendaKerusakan;
        if ($totalDendaDetail > 0) {
            $transaksi->increment('denda', $totalDendaDetail);
        }

        // Check if all items in transaction are returned
        if ($transaksi->semuaDikembalikan()) {
            $transaksi->update([
                'tanggal_kembali' => now(),
                'status' => 'dikembalikan',
            ]);
        }
        
        $msg = "Buku {$detail->buku->judul} berhasil dikembalikan!";
        if ($totalDendaDetail > 0) {
            $msg .= ' Total denda (terlambat/rusak/hilang): Rp' . number_format($totalDendaDetail, 0, ',', '.');
        }
        
        return back()->with('success', $msg);
    }

    /**
     * Cetak Bukti Transaksi (Admin) — Preview / Stream / Download
     */
    public function cetakBukti(Request $request, Transaksi $transaksi)
    {
        $transaksi->load(['anggota', 'detailTransaksi.buku.kategori.rak']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.transaksi.cetak-bukti', compact('transaksi'))
            ->setPaper('a5', 'portrait');
        
        $filename = 'Bukti_Transaksi_' . $transaksi->id . '.pdf';

        if ($request->has('download')) {
            return $pdf->download($filename);
        }

        if ($request->has('stream')) {
            return $pdf->stream($filename);
        }

        return view('components.preview-pdf', [
            'title' => 'Bukti Transaksi #TRX-' . str_pad($transaksi->id, 5, '0', STR_PAD_LEFT),
            'streamUrl' => route('transaksi.cetak_bukti', ['transaksi' => $transaksi->id, 'stream' => 1]),
            'downloadUrl' => route('transaksi.cetak_bukti', ['transaksi' => $transaksi->id, 'download' => 1]),
            'backUrl' => route('transaksi.index'),
        ]);
    }
}
