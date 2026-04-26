<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bukti Transaksi #TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #000;
            background: #fff;
            font-size: 10px;
            line-height: 1.3;
        }
        .receipt { max-width: 100%; margin: 0 auto; padding: 15px; }

        /* ===== HEADER ===== */
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 10px; }
        .header h1 { font-size: 14px; font-weight: 700; text-transform: uppercase; margin-bottom: 2px; }
        .header-sub { font-size: 9px; color: #333; margin-bottom: 4px; }
        .trx-badge { font-weight: 700; font-size: 11px; }

        /* ===== SEPARATOR ===== */
        .sep { border: none; border-top: 1px dashed #999; margin: 8px 0; }

        /* ===== INFO ROW ===== */
        .info-table { width: 100%; margin-bottom: 10px; border-collapse: collapse; }
        .info-table td { padding: 2px 0; vertical-align: top; }
        .info-label { width: 25%; font-weight: bold; color: #333; }
        .info-value { width: 75%; }

        /* ===== BOOK TABLE ===== */
        .book-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .book-table th, .book-table td { border: 1px solid #000; padding: 4px 6px; text-align: left; }
        .book-table th { background-color: #f0f0f0; font-weight: bold; font-size: 9px; text-transform: uppercase; text-align: center; }
        .book-table td { font-size: 10px; }
        .text-center { text-align: center !important; }

        /* ===== STATUS ===== */
        .status { font-weight: bold; text-transform: uppercase; font-size: 9px; }

        /* ===== FOOTER ===== */
        .footer { text-align: center; margin-top: 15px; border-top: 1px solid #000; padding-top: 8px; font-size: 9px; }
        .barcode { text-align: center; margin-top: 10px; }
        .barcode-lines { font-family: 'DejaVu Sans Mono', monospace; font-size: 8px; letter-spacing: 1px; }
        .barcode-num { font-family: 'DejaVu Sans Mono', monospace; font-size: 9px; margin-top: 2px; }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>PERPUSTAKAAN (ADMIN)</h1>
            <div class="header-sub">Bukti Peminjaman Buku</div>
            <div class="trx-badge">#TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</div>
        </div>

        <table class="info-table">
            <tr>
                <td class="info-label">Peminjam:</td>
                <td class="info-value">{{ $transaksi->anggota->nama }} (NIS: {{ $transaksi->anggota->nis }} | Kelas: {{ $transaksi->anggota->kelas }})</td>
            </tr>
            <tr>
                <td class="info-label">Tanggal:</td>
                <td class="info-value">Pinjam: {{ $transaksi->tanggal_pinjam->format('d/m/Y') }} &nbsp;|&nbsp; Batas Kembali: {{ $transaksi->tanggal_pengembalian ? $transaksi->tanggal_pengembalian->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Status:</td>
                <td class="info-value">
                    <span class="status">
                        @if($transaksi->status == 'menunggu') Menunggu
                        @elseif($transaksi->status == 'dipinjam') Dipinjam
                        @elseif($transaksi->status == 'dikembalikan') Selesai ({{ $transaksi->tanggal_kembali->format('d/m/Y') }})
                        @else Ditolak @endif
                    </span>
                </td>
            </tr>
        </table>

        <strong>Detail Buku ({{ $transaksi->detailTransaksi->sum('jumlah') }} buku):</strong>
        <table class="book-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="45%">Judul Buku</th>
                    <th width="20%">Rak</th>
                    <th width="10%">Qty</th>
                    <th width="20%">Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->detailTransaksi as $i => $detail)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ $detail->buku->judul }}</strong><br>
                        <span style="font-size:8px; color:#555;">{{ $detail->buku->penulis }}</span>
                    </td>
                    <td class="text-center" style="font-size: 8px;">
                        @if($detail->buku->kategori && $detail->buku->kategori->rak)
                            {{ $detail->buku->kategori->rak->nama_rak }} 
                            {{ $detail->buku->kategori->rak->lokasi ? '('.$detail->buku->kategori->rak->lokasi.')' : '' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $detail->jumlah }}</td>
                    <td class="text-center" style="font-size: 8px;">
                        @if($detail->kondisi_buku !== 'baik')
                            <strong style="color: #dc2626;">{{ strtoupper($detail->kondisi_buku) }}</strong>
                        @else
                            BAIK
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @php
            $totalDenda = ($transaksi->denda ?? 0) + $transaksi->totalDendaKerusakan();
        @endphp

        @if($totalDenda > 0)
        <table class="info-table" style="margin-top: 10px; border-top: 1px dashed #000; padding-top: 5px;">
            <tr>
                <td class="info-label" style="color: #dc2626;">Total Denda:</td>
                <td class="info-value">
                    <strong style="color: #dc2626;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong>
                    <span style="font-size: 8px;">
                        (Terlambat: Rp {{ number_format($transaksi->denda, 0, ',', '.') }}, Kerusakan: Rp {{ number_format($transaksi->totalDendaKerusakan(), 0, ',', '.') }})
                    </span>
                </td>
            </tr>
        </table>
        @else
        <div style="text-align: right; font-size: 9px; margin-top: 5px;"><strong>✓ Tidak Ada Denda</strong></div>
        @endif

        <div class="footer">
            <p>Dokumen ini dicetak oleh Admin sebagai bukti transaksi resmi Perpustakaan.</p>
            <div class="barcode">
                <div class="barcode-lines">║│║║│║│║║│║│║║│║│║║│║│║║│║</div>
                <div class="barcode-num">TRX{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }} - Cetak: {{ now()->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>
</body>
</html>
