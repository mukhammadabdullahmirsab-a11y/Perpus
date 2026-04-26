<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Peminjaman - Perpustakaan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #1e293b; padding: 20px; }
        
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #4f46e5; padding-bottom: 20px; }
        .header h1 { font-size: 22px; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
        .header h2 { font-size: 16px; font-weight: 600; color: #4f46e5; margin-bottom: 8px; }
        .header p { font-size: 11px; color: #64748b; }
        
        .stats { display: flex; gap: 15px; margin-bottom: 25px; }
        .stat-box { flex: 1; padding: 12px 16px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .stat-box .label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 4px; }
        .stat-box .value { font-size: 20px; font-weight: 800; color: #1e293b; }
        .stat-box.yellow { border-left: 3px solid #f59e0b; background: #fffbeb; }
        .stat-box.green { border-left: 3px solid #22c55e; background: #f0fdf4; }
        .stat-box.red { border-left: 3px solid #ef4444; background: #fef2f2; }
        .stat-box.blue { border-left: 3px solid #4f46e5; background: #eef2ff; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #f1f5f9; padding: 10px 12px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; border-bottom: 2px solid #e2e8f0; }
        td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; font-size: 11px; }
        tr:hover { background: #f8fafc; }
        
        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-red { color: #dc2626; font-weight: 700; }
        
        .footer { text-align: center; margin-top: 40px; padding-top: 15px; border-top: 1px solid #e2e8f0; }
        .footer p { font-size: 10px; color: #94a3b8; }
        
        .signature { margin-top: 50px; display: flex; justify-content: flex-end; }
        .signature-box { text-align: center; width: 200px; }
        .signature-box .date { font-size: 11px; color: #475569; margin-bottom: 60px; }
        .signature-box .line { border-top: 1px solid #1e293b; padding-top: 5px; font-size: 11px; font-weight: 600; }

        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>PERPUSTAKAAN DIGITAL</h1>
        <h2>Laporan Peminjaman Buku</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($validated['dari_tanggal'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($validated['sampai_tanggal'])->format('d M Y') }}
        @if(!empty($validated['status'])) | Status: {{ ucfirst($validated['status']) }} @endif
        </p>
    </div>


    <!-- Table -->
    @if($transaksis->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda Terlambat</th>
                <th>Denda Kerusakan</th>
                <th>Total Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $transaksi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $transaksi->anggota->nama }}</strong><br>
                    <span style="color: #64748b;">{{ $transaksi->anggota->nis }} - {{ $transaksi->anggota->kelas }}</span>
                </td>
                <td>
                    @foreach($transaksi->detailTransaksi as $i => $detail)
                    <div style="{{ $i > 0 ? 'margin-top: 4px; padding-top: 4px; border-top: 1px dashed #e2e8f0;' : '' }}">
                        <strong>{{ $detail->buku->judul }}{{ $detail->jumlah > 1 ? ' (×'.$detail->jumlah.')' : '' }}</strong><br>
                        <span style="color: #64748b;">{{ $detail->buku->penulis }}</span>
                    </div>
                    @endforeach
                </td>
                <td>{{ $transaksi->tanggal_pinjam->format('d/m/Y') }}</td>
                <td>{{ $transaksi->tanggal_pengembalian ? $transaksi->tanggal_pengembalian->format('d/m/Y') : \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->addDays(7)->format('d/m/Y') }}</td>
                <td>{{ $transaksi->tanggal_kembali ? $transaksi->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                <td>
                    @if($transaksi->status == 'dipinjam')
                    <span class="badge badge-yellow">Dipinjam</span>
                    @elseif($transaksi->status == 'menunggu')
                    <span class="badge" style="background: #e2e8f0; color: #475569;">Menunggu</span>
                    @elseif($transaksi->status == 'ditolak')
                    <span class="badge" style="background: #fee2e2; color: #991b1b;">Ditolak</span>
                    @else
                    <span class="badge badge-green">Dikembalikan</span>
                    @endif
                </td>
                <td>
                    @php
                        $denda = $transaksi->status === 'dipinjam' ? $transaksi->hitungDenda() : $transaksi->denda;
                    @endphp
                    @if($denda > 0)
                    <span class="badge-red">Rp{{ number_format($denda, 0, ',', '.') }}</span>
                    @else
                    -
                    @endif
                </td>
                <td>
                    @php $dendaKerusakan = $transaksi->totalDendaKerusakan(); @endphp
                    @if($dendaKerusakan > 0)
                    <span class="badge-red">Rp{{ number_format($dendaKerusakan, 0, ',', '.') }}</span>
                    @else
                    -
                    @endif
                </td>
                <td>
                    @php $totalRowDenda = $denda + $dendaKerusakan; @endphp
                    @if($totalRowDenda > 0)
                    <strong style="color: #dc2626;">Rp{{ number_format($totalRowDenda, 0, ',', '.') }}</strong>
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 40px; color: #94a3b8;">
        <p style="font-size: 14px; font-weight: 600;">Tidak ada data transaksi untuk periode ini.</p>
    </div>
    @endif

    <!-- Signature -->
    <div class="signature">
        <div class="signature-box">
            <div class="date">{{ now()->format('d M Y') }}</div>
            <div class="line">Petugas Perpustakaan</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada {{ now()->format('d M Y H:i') }} | Perpustakaan Digital © {{ date('Y') }}</p>
    </div>
</body>
</html>
