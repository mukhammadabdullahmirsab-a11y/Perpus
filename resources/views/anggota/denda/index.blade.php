@extends('layouts.anggota')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 animate-fade-in">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="flex items-center gap-3">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #ef4444, #b91c1c);"></div>
            <h4 class="text-base font-bold" style="color: var(--text-secondary);">Rekap Denda Saya</h4>
            <span class="ml-auto text-xs font-medium px-2.5 py-1 rounded-full" style="background: var(--bg-hover); color: var(--text-muted);">{{ $transaksis->count() }} transaksi berbayar</span>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="p-5 rounded-xl card-hover" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Denda Keterlambatan</p>
                <h3 class="text-2xl font-black text-yellow-500">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
            </div>
            <div class="p-5 rounded-xl card-hover" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Denda Kerusakan</p>
                <h3 class="text-2xl font-black text-red-500">Rp {{ number_format($totalKerusakan, 0, ',', '.') }}</h3>
            </div>
            <div class="p-5 rounded-xl card-hover" style="background: var(--bg-card); border: 1px solid rgba(239, 68, 68, 0.3); box-shadow: var(--shadow-sm);">
                <p class="text-xs font-semibold uppercase tracking-wider mb-2 text-red-600">Total Harus Dibayar / Sudah Dibayar</p>
                <h3 class="text-2xl font-black text-red-600">Rp {{ number_format($totalSemua, 0, ',', '.') }}</h3>
            </div>
        </div>
        
        @if($transaksis->count() > 0)
        <!-- Data Desktop -->
        <div class="hidden md:block rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead style="background: var(--bg-table-head);">
                        <tr>
                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Transaksi / Buku</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Tgl Pinjam</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Tgl Kembali</th>
                            <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Denda Terlambat</th>
                            <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Denda Rusak</th>
                            <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Total Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border-main)]">
                        @foreach($transaksis as $transaksi)
                        @php
                            $trxDendaLate = $transaksi->detailTransaksi->sum('denda_keterlambatan');
                            $trxDendaRusak = $transaksi->detailTransaksi->sum('denda_kerusakan');
                            $rowTotal = $trxDendaLate + $trxDendaRusak;

                            $isLunas = true;
                            foreach($transaksi->detailTransaksi as $dt) {
                                if (($dt->denda_keterlambatan > 0 || $dt->denda_kerusakan > 0) && $dt->status_denda != 'lunas') {
                                    $isLunas = false;
                                    break;
                                }
                            }
                        @endphp
                        <tr class="transition-colors hover:bg-[var(--bg-hover)]">
                            <td class="px-6 py-4">
                                <p class="font-bold text-sm">TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</p>
                                @foreach($transaksi->detailTransaksi as $detail)
                                    @if($detail->status_denda == 'lunas')
                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        {{ mb_strimwidth($detail->buku->judul, 0, 30, '...') }} 
                                        {!! $detail->kondisi_buku != 'baik' ? '<span class="text-[9px] px-1 bg-red-100 text-red-600 rounded">'.ucfirst($detail->kondisi_buku).'</span>' : '' !!}
                                    </p>
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-sm" style="color: var(--text-secondary);">{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold" style="color: var(--text-primary);">{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right text-sm text-yellow-600 font-medium">
                                Rp {{ number_format($trxDendaLate, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-red-600 font-medium">
                                Rp {{ number_format($trxDendaRusak, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-red-600">
                                @if($isLunas && $rowTotal > 0)
                                    <span class="px-2 py-1 text-[10px] bg-green-100 text-green-700 rounded-full border border-green-200">Sudah Dibayar</span>
                                @else
                                    Rp {{ number_format($rowTotal, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Data Mobile -->
        <div class="md:hidden space-y-4">
            @foreach($transaksis as $transaksi)
            @php
                $trxDendaLate = $transaksi->detailTransaksi->sum('denda_keterlambatan');
                $trxDendaRusak = $transaksi->detailTransaksi->sum('denda_kerusakan');
                $rowTotal = $trxDendaLate + $trxDendaRusak;

                $isLunas = true;
                foreach($transaksi->detailTransaksi as $dt) {
                    if (($dt->denda_keterlambatan > 0 || $dt->denda_kerusakan > 0) && $dt->status_denda != 'lunas') {
                        $isLunas = false;
                        break;
                    }
                }
            @endphp
            <div class="p-4 rounded-xl border relative shadow-sm" style="background: var(--bg-card); border-color: rgba(239, 68, 68, 0.2);">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-bold text-sm">TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Dikembalikan: {{ $transaksi->tanggal_kembali->format('d/m/Y') }}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 mb-3 space-y-2">
                    @foreach($transaksi->detailTransaksi as $detail)
                        @if($detail->status_denda == 'lunas')
                        <div>
                            <p class="text-xs font-medium text-gray-800">{{ $detail->buku->judul }}</p>
                            @if($detail->kondisi_buku != 'baik')
                                <p class="text-[10px] text-red-600">Kondisi: {{ ucfirst($detail->kondisi_buku) }}</p>
                            @endif
                        </div>
                        @endif
                    @endforeach
                </div>
                
                <div class="flex justify-between items-end border-t pt-2" style="border-color: var(--border-main);">
                    <div class="text-[10px] text-gray-500 space-y-1">
                        <p>Terlambat: Rp{{ number_format($trxDendaLate, 0, ',', '.') }}</p>
                        <p>Rusak/Hilang: Rp{{ number_format($trxDendaRusak, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase font-bold text-gray-500">Total Denda</p>
                        @if($isLunas && $rowTotal > 0)
                            <span class="mt-1 inline-block px-2 py-1 text-[10px] bg-green-100 text-green-700 rounded-full border border-green-200">Sudah Dibayar</span>
                        @else
                            <p class="text-lg font-bold text-red-600">Rp{{ number_format($rowTotal, 0, ',', '.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="text-center py-16 rounded-xl" style="background: var(--bg-card); border: 2px dashed var(--empty-border);">
            <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--tag-green-text);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Tidak Ada Denda</h3>
            <p class="mb-6" style="color: var(--text-muted);">Kerja bagus! Anda tidak memiliki catatan denda keterlambatan atau kerusakan buku.</p>
        </div>
        @endif
    </div>
</div>
@endsection
