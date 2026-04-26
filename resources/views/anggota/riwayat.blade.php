@extends('layouts.anggota')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 animate-fade-in">
    <div class="max-w-7xl mx-auto space-y-6">
        
        @if (session('success'))
        <div class="flex items-center gap-3 p-4 rounded-xl" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border);">
            <svg class="w-5 h-5 shrink-0" style="color: var(--alert-success-text);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="text-sm font-medium" style="color: var(--alert-success-text);">{{ session('success') }}</p>
        </div>
        @endif
        @if (session('error'))
        <div class="flex items-center gap-3 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
            <svg class="w-5 h-5 shrink-0" style="color: var(--alert-error-text);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
            <p class="text-sm font-medium" style="color: var(--alert-error-text);">{{ session('error') }}</p>
        </div>
        @endif
        
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="p-5 rounded-xl flex items-center gap-4 card-hover" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider mb-0.5" style="color: var(--text-muted);">Total Peminjaman</p>
                    <h3 class="text-2xl font-black" style="color: var(--text-primary);">{{ $transaksis->count() }}</h3>
                </div>
            </div>
            <div class="p-5 rounded-xl flex items-center gap-4 card-hover" style="background: var(--bg-card); border: 1px solid rgba(245, 158, 11, 0.3); box-shadow: var(--shadow-sm);">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider mb-0.5" style="color: var(--tag-yellow-text);">Sedang Dipinjam</p>
                    <h3 class="text-2xl font-black" style="color: var(--tag-yellow-text);">{{ $transaksis->whereIn('status', ['dipinjam', 'menunggu'])->count() }}</h3>
                </div>
            </div>
            <div class="p-5 rounded-xl flex items-center gap-4 card-hover" style="background: var(--bg-card); border: 1px solid rgba(16, 185, 129, 0.3); box-shadow: var(--shadow-sm);">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider mb-0.5" style="color: var(--tag-green-text);">Dikembalikan</p>
                    <h3 class="text-2xl font-black" style="color: var(--tag-green-text);">{{ $transaksis->where('status', 'dikembalikan')->count() }}</h3>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #6366f1, #8b5cf6);"></div>
            <h4 class="text-base font-bold" style="color: var(--text-secondary);">Daftar Riwayat</h4>
            <span class="ml-auto text-xs font-medium px-2.5 py-1 rounded-full" style="background: var(--bg-hover); color: var(--text-muted);">{{ $transaksis->count() }} data</span>
        </div>
        
        @if($transaksis->count() > 0)
        <!-- Tabel Tampilan Desktop -->
        <div class="hidden md:block rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead style="background: var(--bg-table-head);">
                        <tr>
                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Informasi Buku</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Tanggal Pinjam</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Batas Kembali</th>
                            <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Dikembalikan</th>
                            <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Status</th>
                            <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Denda</th>
                            <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border-main)]">
                        @foreach($transaksis as $transaksi)
                        <tr class="transition-colors hover:bg-[var(--bg-hover)]">
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-12 rounded flex items-center justify-center shrink-0 shadow-sm" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                        <svg class="w-5 h-5 text-white opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        @foreach($transaksi->detailTransaksi as $i => $detail)
                                        <div class="{{ $i > 0 ? 'mt-1.5 pt-1.5 border-t' : '' }}" style="border-color: var(--border-main);">
                                            <p class="font-bold text-sm truncate" style="color: var(--text-primary); max-width: 200px;" title="{{ $detail->buku->judul }}">{{ mb_strimwidth($detail->buku->judul, 0, 35, '...') }}{{ $detail->jumlah > 1 ? ' (×'.$detail->jumlah.')' : '' }}</p>
                                            <p class="text-xs truncate" style="color: var(--text-muted); max-width: 200px;">{{ mb_strimwidth($detail->buku->penulis, 0, 25, '...') }}</p>
                                        </div>
                                        @endforeach
                                        
                                        @if($transaksi->status == 'dipinjam')
                                            @php $firstDetail = $transaksi->detailTransaksi->first(); @endphp
                                            @if($firstDetail && $firstDetail->buku->kategori && $firstDetail->buku->kategori->rak)
                                            <div class="mt-2 inline-flex items-center gap-1.5 px-2 py-1 rounded-md" style="background: rgba(16, 185, 129, 0.1); border: 1px dashed rgba(16, 185, 129, 0.4);">
                                                <svg class="w-3.5 h-3.5" style="color: var(--tag-green-text);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                                <span class="text-[10px] font-bold uppercase tracking-wider" style="color: var(--tag-green-text);">Ambil di: {{ $firstDetail->buku->kategori->rak->nama_rak }} {{ $firstDetail->buku->kategori->rak->lokasi ? '('.$firstDetail->buku->kategori->rak->lokasi.')' : '' }}</span>
                                            </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium" style="color: var(--text-secondary);">
                                {{ $transaksi->tanggal_pinjam->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @foreach($transaksi->detailTransaksi as $i => $detail)
                                    <div class="{{ $i > 0 ? 'mt-1.5 pt-1.5 border-t' : '' }}" style="border-color: var(--border-main);">
                                        @if($detail->tanggal_pengembalian)
                                            @if($detail->status == 'dipinjam' && now()->gt($detail->tanggal_pengembalian))
                                                <div class="flex items-center gap-1.5 font-bold" style="color: var(--tag-red-text);">
                                                    <span>{{ $detail->tanggal_pengembalian->format('d M y') }}</span>
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                </div>
                                            @elseif($detail->status == 'dipinjam')
                                                <div class="font-medium" style="color: var(--tag-green-text);">{{ $detail->tanggal_pengembalian->format('d M y') }}</div>
                                            @else
                                                <span style="color: var(--text-secondary);">{{ $detail->tanggal_pengembalian->format('d M y') }}</span>
                                            @endif
                                        @else
                                            <span style="color: var(--text-dimmed);">-</span>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-sm font-medium" style="color: var(--text-secondary);">
                                @foreach($transaksi->detailTransaksi as $i => $detail)
                                    <div class="{{ $i > 0 ? 'mt-1.5 pt-1.5 border-t' : '' }}" style="border-color: var(--border-main);">
                                        @if($detail->tanggal_kembali) 
                                            {{ $detail->tanggal_kembali->format('d M y') }} 
                                        @else 
                                            <span style="color: var(--text-dimmed);">-</span> 
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-center">
                                @foreach($transaksi->detailTransaksi as $i => $detail)
                                    <div class="{{ $i > 0 ? 'mt-1.5 pt-1.5 border-t border-gray-600/10' : '' }}">
                                        @if($transaksi->status == 'menunggu')
                                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider" style="background: var(--tag-blue-bg); color: var(--tag-blue-text);">Menunggu</span>
                                        @elseif($transaksi->status == 'ditolak')
                                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider" style="background: var(--tag-red-bg); color: var(--tag-red-text);">Ditolak</span>
                                        @elseif($detail->status == 'dipinjam')
                                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider" style="background: var(--tag-yellow-bg); color: var(--tag-yellow-text);">Dipinjam</span>
                                        @elseif($detail->status == 'dikembalikan')
                                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider" style="background: var(--tag-green-bg); color: var(--tag-green-text);">Selesai</span>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                @foreach($transaksi->detailTransaksi as $i => $detail)
                                    <div class="{{ $i > 0 ? 'mt-1.5 pt-1.5 border-t' : '' }}" style="border-color: var(--border-main);">
                                        @if($detail->denda_kerusakan > 0)
                                            <span class="font-bold whitespace-nowrap block" style="color: var(--tag-red-text);">Rp {{ number_format($detail->denda_kerusakan, 0, ',', '.') }}</span>
                                        @endif
                                        @if($detail->status == 'dikembalikan' && $detail->denda_keterlambatan > 0)
                                            <span class="font-bold whitespace-nowrap block" style="color: var(--tag-red-text);">Rp {{ number_format($detail->denda_keterlambatan, 0, ',', '.') }}</span>
                                        @elseif($detail->status == 'dipinjam' && $detail->isTerlambat())
                                            <span class="font-bold whitespace-nowrap block" style="color: var(--tag-yellow-text);">~Rp {{ number_format($detail->hitungDenda(), 0, ',', '.') }}</span>
                                        @elseif($detail->denda_kerusakan <= 0)
                                            <span style="color: var(--text-dimmed);">-</span>
                                        @endif
                                        
                                        @if($detail->status_denda == 'belum_lunas')
                                            <span class="text-[9px] px-1.5 py-0.5 rounded font-bold uppercase mt-1 inline-block" style="background: var(--tag-red-bg); color: var(--tag-red-text); border: 1px solid var(--tag-red-bg);">Belum Lunas</span>
                                        @elseif($detail->status_denda == 'lunas')
                                            <span class="text-[9px] px-1.5 py-0.5 rounded font-bold uppercase mt-1 inline-block" style="background: var(--tag-green-bg); color: var(--tag-green-text); border: 1px solid var(--tag-green-bg);">Lunas</span>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-center">
                                @foreach($transaksi->detailTransaksi as $i => $detail)
                                    <div class="{{ $i > 0 ? 'mt-1.5 pt-1.5 border-t border-gray-600/10 flex items-center justify-center gap-2' : 'flex items-center justify-center gap-2' }}">
                                        @if($i == 0)
                                        <a href="{{ route('anggota.cetak_bukti', $transaksi->id) }}" class="px-2 py-1 rounded shadow-sm font-medium text-[10px] uppercase tracking-wider transition-all" style="color: var(--text-primary); border: 1px solid var(--border-input); background: var(--bg-hover);" title="Cetak Bukti">
                                            Cetak
                                        </a>
                                        @endif
                                        
                                        @if($detail->status == 'dipinjam')
                                            <form action="{{ route('anggota.kembalikan', $detail->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 rounded text-white font-medium text-[10px] uppercase tracking-wider transition-all hover:opacity-90" style="background: linear-gradient(135deg, #059669, #10b981);" onclick="return confirm('Kembalikan buku ini?')">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tampilan Card untuk Mobile -->
        <div class="md:hidden space-y-4">
            @foreach($transaksis as $transaksi)
            <div class="p-4 rounded-xl border relative shadow-sm" style="background: var(--bg-card); border-color: var(--border-main);">
                <div class="flex flex-col mb-3">
                    <div class="flex items-center gap-3 mb-2">
                         <div class="w-10 h-12 rounded flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                            <svg class="w-5 h-5 text-white opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                        </div>
                        <div>
                            @foreach($transaksi->detailTransaksi as $i => $detail)
                            <div class="{{ $i > 0 ? 'mt-1' : '' }}">
                                <h5 class="text-sm font-bold m-0" style="color: var(--text-primary); line-height: 1.3;">{{ $detail->buku->judul }}{{ $detail->jumlah > 1 ? ' (×'.$detail->jumlah.')' : '' }}</h5>
                                <p class="text-xs m-0" style="color: var(--text-muted);">{{ Str::limit($detail->buku->penulis, 25) }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    @if($transaksi->status == 'dipinjam')
                        @php $firstDetail = $transaksi->detailTransaksi->first(); @endphp
                        @if($firstDetail && $firstDetail->buku->kategori && $firstDetail->buku->kategori->rak)
                        <div class="mb-3 p-2.5 rounded-lg flex items-start gap-2" style="background: rgba(16, 185, 129, 0.05); border: 1px dashed rgba(16, 185, 129, 0.3);">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: var(--tag-green-text);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider mb-0.5" style="color: var(--tag-green-text);">Lokasi Pengambilan Buku</p>
                                <p class="text-xs font-semibold m-0" style="color: var(--text-secondary);">{{ $firstDetail->buku->kategori->rak->nama_rak }} {{ $firstDetail->buku->kategori->rak->lokasi ? ' - '.$firstDetail->buku->kategori->rak->lokasi : '' }}</p>
                            </div>
                        </div>
                        @endif
                    @endif
                    
                <div class="mt-4 border-t pt-3" style="border-color: var(--border-main);">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-xs" style="color: var(--text-secondary);">Detail Buku</span>
                        <a href="{{ route('anggota.cetak_bukti', $transaksi->id) }}" class="px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider" style="background: var(--bg-card); color: var(--text-primary); border: 1px solid var(--border-input);">
                            Cetak Bukti
                        </a>
                    </div>
                    
                    @foreach($transaksi->detailTransaksi as $i => $detail)
                    <div class="grid grid-cols-2 gap-y-2 gap-x-2 text-[11px] {{ $i > 0 ? 'mt-3 pt-3 border-t border-dashed' : 'mt-2' }}" style="border-color: var(--border-main);">
                        <div class="col-span-2 flex justify-between items-start">
                             <div class="pr-2">
                                <h6 class="font-bold m-0" style="color: var(--text-primary);">{{ $detail->buku->judul }}</h6>
                             </div>
                             <div>
                                @if($transaksi->status == 'menunggu')
                                    <span class="inline-block px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider" style="background: var(--tag-blue-bg); color: var(--tag-blue-text);">Menunggu</span>
                                @elseif($transaksi->status == 'ditolak')
                                    <span class="inline-block px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider" style="background: var(--tag-red-bg); color: var(--tag-red-text);">Ditolak</span>
                                @elseif($detail->status == 'dipinjam')
                                    <span class="inline-block px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider" style="background: var(--tag-yellow-bg); color: var(--tag-yellow-text);">Dipinjam</span>
                                @elseif($detail->status == 'dikembalikan')
                                    <span class="inline-block px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider" style="background: var(--tag-green-bg); color: var(--tag-green-text);">Dikembalikan</span>
                                @endif
                             </div>
                        </div>
                        
                        <div>
                            <p class="font-semibold mb-[2px] uppercase opacity-70 w-full" style="color: var(--text-dimmed);">Tenggat</p>
                            <p class="font-medium m-0 @if($detail->status == 'dipinjam' && $detail->tanggal_pengembalian && now()->gt($detail->tanggal_pengembalian)) text-red-500 @else text-[var(--text-secondary)] @endif">
                                {{ $detail->tanggal_pengembalian ? $detail->tanggal_pengembalian->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="font-semibold mb-[2px] uppercase opacity-70 w-full" style="color: var(--text-dimmed);">Denda</p>
                            @if($detail->denda_kerusakan > 0)
                                <p class="font-bold m-0 text-red-500">Rp{{ number_format($detail->denda_kerusakan, 0, ',', '.') }}</p>
                            @endif
                            @if($detail->status == 'dikembalikan' && $detail->denda_keterlambatan > 0)
                                <p class="font-bold m-0 text-red-500">Rp{{ number_format($detail->denda_keterlambatan, 0, ',', '.') }}</p>
                            @elseif($detail->status == 'dipinjam' && $detail->isTerlambat())
                                <p class="font-bold m-0 text-yellow-500">~Rp{{ number_format($detail->hitungDenda(), 0, ',', '.') }}</p>
                            @elseif($detail->denda_kerusakan <= 0)
                                <p class="m-0 text-[var(--text-dimmed)]">-</p>
                            @endif
                            
                            @if($detail->status_denda == 'belum_lunas')
                                <span class="text-[9px] px-1.5 py-0.5 rounded font-bold uppercase mt-1 inline-block" style="background: var(--tag-red-bg); color: var(--tag-red-text); border: 1px solid var(--tag-red-bg);">Belum Lunas</span>
                            @elseif($detail->status_denda == 'lunas')
                                <span class="text-[9px] px-1.5 py-0.5 rounded font-bold uppercase mt-1 inline-block" style="background: var(--tag-green-bg); color: var(--tag-green-text); border: 1px solid var(--tag-green-bg);">Lunas</span>
                            @endif
                        </div>
                        
                        @if($detail->status == 'dipinjam')
                        <div class="col-span-2 mt-1">
                            <form action="{{ route('anggota.kembalikan', $detail->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-center px-4 py-1.5 rounded-lg text-white font-semibold text-[11px] transition-all" style="background: linear-gradient(135deg, #059669, #10b981);"
                                        onclick="return confirm('Yakin ingin memproses pengembalian buku ini?')">Kembalikan Buku</button>
                            </form>
                        </div>
                        @elseif($detail->tanggal_kembali)
                        <div class="col-span-2 mt-1">
                            <p class="font-semibold text-[10px] mb-[2px] uppercase opacity-70 w-full" style="color: var(--text-dimmed);">Tgl Kembali</p>
                            <p class="font-medium m-0 text-[11px]" style="color: var(--text-secondary);">{{ $detail->tanggal_kembali->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 rounded-xl" style="background: var(--bg-card); border: 2px dashed var(--empty-border);">
            <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
            <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Belum Ada Riwayat</h3>
            <p class="mb-6" style="color: var(--text-muted);">Peminjaman buku Anda akan muncul di sini.</p>
            <a href="{{ route('anggota.katalog') }}" class="inline-block px-6 py-3 rounded-lg text-white font-semibold no-underline transition-all hover:shadow-lg" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">Jelajahi Katalog</a>
        </div>
        @endif
    </div>
</div>
@endsection
