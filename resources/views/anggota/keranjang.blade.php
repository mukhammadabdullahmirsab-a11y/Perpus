@extends('layouts.anggota')

@section('content')
<div class="py-10 px-6">
    <div class="max-w-3xl mx-auto">
        
        <!-- Back Link -->
        <a href="{{ route('anggota.katalog') }}" class="inline-flex items-center gap-2 text-sm font-semibold no-underline mb-6 hover:opacity-80 transition-colors" style="color: var(--nav-active-text);">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali ke Katalog
        </a>

        <h1 class="text-2xl font-black mb-6 flex items-center gap-3" style="color: var(--text-primary);">
            🛒 Keranjang Peminjaman
            @if(count($keranjang) > 0)
            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white;">{{ count($keranjang) }} buku</span>
            @endif
        </h1>

        @if (session('success'))
        <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border);">
            <p style="color: var(--alert-success-text); font-size: 13px; font-weight: 500;">✅ {{ session('success') }}</p>
        </div>
        @endif
        @if (session('error'))
        <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
            <p style="color: var(--alert-error-text); font-size: 13px; font-weight: 500;">❌ {{ session('error') }}</p>
        </div>
        @endif

        @if(count($keranjang) > 0)
        <form action="{{ route('anggota.keranjang.checkout') }}" method="POST">
            @csrf

            <!-- Info Box -->
            <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background: var(--tag-indigo-bg); border: 1px solid rgba(99, 102, 241, 0.2);">
                <div class="text-xl" style="color: var(--tag-indigo-text);">ℹ️</div>
                <p class="text-xs font-medium" style="color: var(--tag-indigo-text);">
                    Semua buku di keranjang akan diajukan sebagai <strong>satu transaksi</strong>. Anda dapat mengatur <strong>tanggal pengembalian berbeda</strong> untuk tiap buku. Denda keterlambatan Rp1.000/hari berlaku setelah melewati tanggal pengembalian.
                </p>
            </div>

            <!-- Book Cards -->
            <div class="space-y-4 mb-6">
                @foreach($keranjang as $index => $item)
                @php $buku = $bukus[$item['buku_id']] ?? null; @endphp
                @if($buku)
                <div class="p-4 rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                    <div class="flex gap-4">
                        <!-- Book Cover -->
                        <div class="w-20 h-28 rounded-xl overflow-hidden shrink-0 shadow-md" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                            @if($buku->cover_image)
                                <img src="{{ asset('storage/' . $buku->cover_image) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Book Info & Date -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <h3 class="text-sm font-bold truncate" style="color: var(--text-primary);">
                                        {{ $buku->judul }}
                                        @if(isset($item['jumlah']) && $item['jumlah'] > 1)
                                            <span class="text-xs font-semibold text-indigo-500 ml-1">(×{{ $item['jumlah'] }})</span>
                                        @endif
                                    </h3>
                                    <p class="text-xs mt-0.5" style="color: var(--text-muted);">{{ $buku->penulis }} • {{ $buku->penerbit }}</p>
                                </div>
                                <!-- Remove Button -->
                            </div>
                            <div class="flex items-center gap-2 mt-2 flex-wrap">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold" style="background: var(--tag-green-bg); color: var(--tag-green-text);">Stok: {{ $buku->stok }}</span>
                                @if($buku->kategori)
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold" style="background: var(--tag-indigo-bg); color: var(--tag-indigo-text);">{{ $buku->kategori->nama_kategori }}</span>
                                @endif
                            </div>

                            <!-- Per-Book Date Picker -->
                            <div class="mt-3">
                                <label class="block text-[10px] font-bold uppercase tracking-wider mb-1" style="color: var(--text-dimmed);">📅 Tanggal Pengembalian</label>
                                <input type="date" name="tanggal_pengembalian[{{ $index }}]" required min="{{ now()->addDay()->format('Y-m-d') }}"
                                       class="w-full px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                                       style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                                @error("tanggal_pengembalian.$index")
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Remove Button -->
                        <div class="shrink-0">
                            <button type="button" onclick="document.getElementById('hapus-form-{{ $index }}').submit()" 
                                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:opacity-80"
                                    style="background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.3);"
                                    title="Hapus dari keranjang">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full px-8 py-3.5 rounded-xl text-white font-bold text-sm transition-all hover:shadow-lg hover:-translate-y-0.5 inline-flex items-center justify-center gap-2" 
                    style="background: linear-gradient(135deg, #059669, #10b981); box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);"
                    onclick="return confirm('Ajukan peminjaman {{ count($keranjang) }} buku sekaligus?')">
                📚 Ajukan Peminjaman {{ count($keranjang) }} Buku
            </button>
        </form>

        <!-- Hidden remove forms (outside the main form) -->
        @foreach($keranjang as $index => $item)
        <form id="hapus-form-{{ $index }}" action="{{ route('anggota.keranjang.hapus', $index) }}" method="POST" class="hidden">
            @csrf
        </form>
        @endforeach

        @else
        <!-- Empty Cart -->
        <div class="text-center py-16 rounded-xl" style="background: var(--bg-card); border: 2px dashed var(--empty-border);">
            <div class="text-6xl mb-4">🛒</div>
            <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Keranjang Kosong</h3>
            <p class="mb-6" style="color: var(--text-muted);">Tambahkan buku dari katalog untuk memulai peminjaman.</p>
            <a href="{{ route('anggota.katalog') }}" class="inline-block px-6 py-3 rounded-lg text-white font-semibold no-underline transition-all hover:shadow-lg" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">Jelajahi Katalog</a>
        </div>
        @endif
        
    </div>
</div>
@endsection
