<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bukti Transaksi #TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #1e293b;
            background: #fff;
            font-size: 11px;
            line-height: 1.4;
        }
        .receipt-container {
            max-width: 420px;
            margin: 10px auto;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 30px;
            position: relative;
        }
        
        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            font-weight: 900;
            color: rgba(226, 232, 240, 0.2);
            z-index: -1;
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* ===== HEADER ===== */
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #6366f1;
        }
        .header h1 {
            font-size: 18px;
            font-weight: 900;
            color: #4338ca;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .header-sub {
            font-size: 9px;
            color: #64748b;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .trx-badge {
            margin-top: 15px;
            display: inline-block;
            background: #f1f5f9;
            color: #475569;
            font-size: 11px;
            font-weight: 800;
            padding: 6px 16px;
            border-radius: 8px;
            border: 1px dashed #cbd5e1;
        }

        /* ===== INFO GRID ===== */
        .section-header {
            font-size: 9px;
            color: #4338ca;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: block;
            border-left: 3px solid #6366f1;
            padding-left: 8px;
        }
        
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .label {
            width: 35%;
            font-size: 10px;
            color: #64748b;
            font-weight: 600;
        }
        .value {
            width: 65%;
            font-weight: 700;
            color: #0f172a;
            text-align: right;
        }

        /* ===== STATUS BADGES ===== */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .status-menunggu { background: #eff6ff; color: #2563eb; }
        .status-dipinjam { background: #fffbeb; color: #d97706; }
        .status-dikembalikan { background: #ecfdf5; color: #059669; }
        .status-ditolak { background: #fff1f2; color: #e11d48; }

        /* ===== BOOK SECTION ===== */
        .book-list {
            margin-bottom: 20px;
        }
        .book-item {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 8px;
        }
        .book-title {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
        }
        .book-meta {
            font-size: 10px;
            color: #64748b;
        }
        .book-location {
            margin-top: 8px;
            padding: 6px 10px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 10px;
        }
        .location-label {
            font-size: 8px;
            color: #94a3b8;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        /* ===== FINES & TOTALS ===== */
        .summary-box {
            margin-top: 15px;
            padding: 15px;
            background: #fdf2f2;
            border-radius: 10px;
            border: 1px solid #fee2e2;
        }
        .fine-label {
            color: #dc2626;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .fine-value {
            color: #b91c1c;
            font-size: 16px;
            font-weight: 900;
        }
        .no-fine {
            text-align: center;
            padding: 10px;
            color: #059669;
            font-weight: 700;
            background: #f0fdf4;
            border-radius: 8px;
            font-size: 10px;
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }
        .footer p {
            font-size: 9px;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .thanks {
            font-size: 11px;
            font-weight: 800;
            color: #4338ca;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .barcode-container {
            margin: 15px 0;
            text-align: center;
        }
        .barcode-strip {
            height: 25px;
            color: #cbd5e1;
            font-family: monospace;
            font-size: 14px;
            letter-spacing: -2px;
            overflow: hidden;
        }
        .barcode-id {
            font-family: monospace;
            font-size: 9px;
            color: #94a3b8;
            letter-spacing: 2px;
        }
        .print-date {
            font-size: 8px;
            color: #cbd5e1;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="watermark">OFFICIAL</div>

        {{-- ===== HEADER ===== --}}
        <div class="header">
            <h1>PERPUSTAKAAN</h1>
            <div class="header-sub">SISTEM INFORMASI DIGITAL</div>
            <div class="trx-badge">#TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</div>
        </div>

        {{-- ===== PEMINJAM ===== --}}
        <div class="section-header">Peminjam</div>
        <table class="info-table">
            <tr>
                <td class="label">Nama</td>
                <td class="value">{{ $anggota->nama }}</td>
            </tr>
            <tr>
                <td class="label">NIS / Kelas</td>
                <td class="value">{{ $anggota->nis }} / {{ $anggota->kelas }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td class="value">
                    @if($transaksi->status == 'menunggu')
                        <span class="status-badge status-menunggu">Menunggu</span>
                    @elseif($transaksi->status == 'dipinjam')
                        <span class="status-badge status-dipinjam">Dipinjam</span>
                    @elseif($transaksi->status == 'dikembalikan')
                        <span class="status-badge status-dikembalikan">Kembali</span>
                    @else
                        <span class="status-badge status-ditolak">Ditolak</span>
                    @endif
                </td>
            </tr>
        </table>

        {{-- ===== BUKU ===== --}}
        <div class="section-header">Detail Buku ({{ $transaksi->detailTransaksi->sum('jumlah') }})</div>
        <div class="book-list">
            @foreach($transaksi->detailTransaksi as $i => $detail)
            <div class="book-item">
                <div class="book-title">{{ $detail->buku->judul }}{{ $detail->jumlah > 1 ? ' (×'.$detail->jumlah.')' : '' }}</div>
                <div class="book-meta">{{ $detail->buku->penulis }}</div>
                
                @if($detail->buku->kategori && $detail->buku->kategori->rak)
                <div class="book-location">
                    <div class="location-label">📍 Lokasi Rak</div>
                    <div style="font-weight: 700;">{{ $detail->buku->kategori->rak->nama_rak }}</div>
                </div>
                @endif
                
                @if($detail->kondisi_buku !== 'baik')
                <div style="margin-top: 5px; font-size: 9px; color: #e11d48; font-weight: 800;">⚠ KONDISI: {{ strtoupper($detail->kondisi_buku) }}</div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- ===== WAKTU ===== --}}
        <div class="section-header">Waktu</div>
        <table class="info-table">
            <tr>
                <td class="label">Tgl Pinjam</td>
                <td class="value">{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
            </tr>
            <tr>
                <td class="label">Tenggat</td>
                <td class="value" style="color: #4338ca;">{{ $transaksi->tanggal_pengembalian ? $transaksi->tanggal_pengembalian->format('d M Y') : '-' }}</td>
            </tr>
            @if($transaksi->tanggal_kembali)
            <tr>
                <td class="label">Tgl Kembali</td>
                <td class="value" style="color: #059669;">{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
            </tr>
            @endif
        </table>

        {{-- ===== DENDA ===== --}}
        @php
            $totalDenda = ($transaksi->denda ?? 0) + $transaksi->totalDendaKerusakan();
        @endphp

        @if($totalDenda > 0)
        <div class="summary-box">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; vertical-align: middle;">
                    <div class="fine-label">Total Denda</div>
                    <div class="fine-value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                </div>
                <div style="display: table-cell; vertical-align: middle; text-align: right; font-size: 8px; color: #dc2626; font-weight: 700;">
                    Status: BELUM LUNAS
                </div>
            </div>
        </div>
        @else
        <div class="no-fine">✓ BEBAS DENDA</div>
        @endif

        {{-- ===== FOOTER ===== --}}
        <div class="footer">
            <div class="thanks">Terima Kasih</div>
            <p>Bukti transaksi resmi Perpustakaan Sekolah.</p>
            <p>Harap kembalikan buku tepat pada waktunya.</p>

            <div class="barcode-container">
                <div class="barcode-strip">|||||||||||||||||||||||||||||||||||||||||||||||||||||</div>
                <div class="barcode-id">TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>

            <div class="print-date">Dicetak pada {{ now()->translatedFormat('d F Y H:i') }}</div>
        </div>
    </div>
</body>
</html>
