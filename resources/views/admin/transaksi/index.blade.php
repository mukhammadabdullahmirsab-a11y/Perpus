<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-xl" style="color: var(--text-primary);">
                Manajemen Transaksi
            </h2>
            <a href="{{ route('transaksi.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-white text-sm font-bold transition-all hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 4px 12px rgba(99,102,241,0.3);">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Tambah Peminjaman
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- Alerts -->
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
                <div class="p-5 rounded-xl flex items-center gap-4" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Total Transaksi</p>
                        <p class="text-2xl font-black" style="color: var(--text-primary);">{{ $transaksis->count() }}</p>
                    </div>
                </div>
                <div class="p-5 rounded-xl flex items-center gap-4" style="background: var(--bg-card); border: 1px solid rgba(245,158,11,0.3); box-shadow: var(--shadow-sm);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--tag-yellow-text);">Sedang Dipinjam</p>
                        <p class="text-2xl font-black" style="color: var(--tag-yellow-text);">{{ $transaksis->where('status', 'dipinjam')->count() }}</p>
                    </div>
                </div>
                <div class="p-5 rounded-xl flex items-center gap-4" style="background: var(--bg-card); border: 1px solid rgba(34,197,94,0.3); box-shadow: var(--shadow-sm);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--tag-green-text);">Dikembalikan</p>
                        <p class="text-2xl font-black" style="color: var(--tag-green-text);">{{ $transaksis->where('status', 'dikembalikan')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="p-5 rounded-2xl" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                <form action="{{ route('transaksi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-end">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Cari Transaksi</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm"
                               style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);"
                               placeholder="Nama anggota, NIS, atau judul buku...">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Status</label>
                        <select name="status" class="px-4 py-2.5 rounded-xl text-sm" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-white text-sm font-bold transition-all hover:-translate-y-0.5 hover:shadow-md" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        Filter
                    </button>
                    @if(request('search') || request('status'))
                    <a href="{{ route('transaksi.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all hover:opacity-80 text-center" style="background: var(--bg-hover); color: var(--text-secondary); border: 1px solid var(--border-main);">
                        Reset
                    </a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom: 1px solid var(--border-main);">
                    <div class="w-1 h-5 rounded-full" style="background: linear-gradient(180deg, #6366f1, #8b5cf6);"></div>
                    <h3 class="font-bold text-sm" style="color: var(--text-primary);">Daftar Transaksi</h3>
                    <span class="ml-auto text-xs font-medium px-2.5 py-1 rounded-full" style="background: var(--bg-hover); color: var(--text-muted);">{{ $transaksis->count() }} data</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead style="background: var(--bg-table-head);">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">No</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Anggota</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Buku</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Tgl Pinjam</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Tenggat</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Tgl Kembali</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Status</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksis as $index => $transaksi)
                            <tr style="border-bottom: 1px solid var(--border-main);">
                                <td class="px-5 py-4 text-sm" style="color: var(--text-muted);">{{ $index + 1 }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                                            {{ substr($transaksi->anggota->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold" style="color: var(--text-primary);">{{ $transaksi->anggota->nama }}</div>
                                            <div class="text-xs" style="color: var(--text-muted);">{{ $transaksi->anggota->nis }} · {{ $transaksi->anggota->kelas }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    @foreach($transaksi->detailTransaksi as $i => $detail)
                                        <div class="{{ $i > 0 ? 'mt-1 pt-1 border-t border-gray-700/20' : '' }}">
                                            <div class="text-sm font-semibold line-clamp-1" style="color: var(--text-primary);">{{ $detail->buku->judul }}{{ $detail->jumlah > 1 ? ' (×'.$detail->jumlah.')' : '' }}</div>
                                            <div class="text-xs" style="color: var(--text-muted);">{{ $detail->buku->penulis }}</div>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap" style="color: var(--text-secondary);">
                                    {{ $transaksi->tanggal_pinjam->format('d M Y') }}
                                </td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">
                                    @if($transaksi->tanggal_pengembalian)
                                        @if($transaksi->status == 'dipinjam' && now()->gt($transaksi->tanggal_pengembalian))
                                            <span class="font-semibold" style="color: var(--tag-red-text);">{{ $transaksi->tanggal_pengembalian->format('d M Y') }}</span>
                                            <div class="text-xs font-medium" style="color: var(--tag-red-text);">⚠️ Terlambat</div>
                                        @else
                                            <span style="color: var(--text-secondary);">{{ $transaksi->tanggal_pengembalian->format('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span style="color: var(--text-dimmed);">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap" style="color: var(--text-secondary);">
                                    {{ $transaksi->tanggal_kembali ? $transaksi->tanggal_kembali->format('d M Y') : '—' }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($transaksi->status == 'menunggu')
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full" style="background: rgba(59,130,246,0.15); color: #60a5fa; border: 1px solid rgba(59,130,246,0.3);">Menunggu</span>
                                    @elseif($transaksi->status == 'dipinjam')
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full" style="background: var(--tag-yellow-bg); color: var(--tag-yellow-text); border: 1px solid rgba(245,158,11,0.3);">Dipinjam</span>
                                    @elseif($transaksi->status == 'dikembalikan')
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full" style="background: var(--tag-green-bg); color: var(--tag-green-text); border: 1px solid rgba(34,197,94,0.3);">Dikembalikan</span>
                                    @else
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full" style="background: var(--tag-red-bg); color: var(--tag-red-text); border: 1px solid rgba(239,68,68,0.3);">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('transaksi.cetak_bukti', $transaksi->id) }}" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all hover:-translate-y-0.5" style="background: var(--tag-green-bg); color: var(--tag-green-text); border: 1px solid rgba(34,197,94,0.3);">Cetak</a>
                                        <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all hover:-translate-y-0.5" style="background: var(--tag-indigo-bg); color: var(--tag-indigo-text); border: 1px solid rgba(99,102,241,0.3);">Edit</a>
                                        <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all hover:-translate-y-0.5" style="background: var(--tag-red-bg); color: var(--tag-red-text); border: 1px solid rgba(239,68,68,0.3);" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <svg class="w-12 h-12 mx-auto mb-3" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>
                                    <p class="text-sm font-medium" style="color: var(--text-muted);">Tidak ada data transaksi</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
