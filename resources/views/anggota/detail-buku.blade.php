@extends('layouts.anggota')

@section('content')
<div class="py-10 px-6">
    <div class="max-w-4xl mx-auto">
        
        <!-- Back Link -->
        <a href="{{ route('anggota.katalog') }}" class="inline-flex items-center gap-2 text-sm font-semibold no-underline mb-6 hover:opacity-80 transition-colors" style="color: var(--nav-active-text);">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali ke Katalog
        </a>

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
        
        <!-- Book Detail Card -->
        <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            <!-- Cover Image (Landscape Showcase) -->
            <div class="w-full flex items-center justify-center" style="background: var(--bg-gradient-cover); height: 420px; padding: 24px;">
                @if($buku->cover_image)
                    <img src="{{ asset('storage/' . $buku->cover_image) }}" alt="Cover {{ $buku->judul }}" class="h-full object-contain rounded-lg" style="max-width: 100%; filter: drop-shadow(0 8px 24px rgba(0,0,0,0.4));">
                @else
                    <div class="flex items-center justify-center">
                        <svg class="w-24 h-24" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                    </div>
                @endif
            </div>
            
            <!-- Info (Below Image) -->
            <div class="p-8">
                <h1 class="text-2xl font-black mb-2" style="color: var(--text-primary);">{{ $buku->judul }}</h1>
                <p class="text-base mb-6" style="color: var(--text-muted);">oleh <span style="color: var(--tag-indigo-text); font-weight: 600;">{{ $buku->penulis }}</span></p>
                
                <!-- Details Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                    <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-main);">
                        <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: var(--text-dimmed);">Penerbit</p>
                        <p class="text-sm font-semibold" style="color: var(--text-primary);">{{ $buku->penerbit }}</p>
                    </div>
                    <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-main);">
                        <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: var(--text-dimmed);">Tahun Terbit</p>
                        <p class="text-sm font-semibold" style="color: var(--text-primary);">{{ $buku->tahun }}</p>
                    </div>
                    @if($buku->kategori)
                    <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-main);">
                        <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: var(--text-dimmed);">Kategori</p>
                        <p class="text-sm font-semibold" style="color: var(--text-primary);">{{ $buku->kategori->nama_kategori }}</p>
                    </div>
                    @endif
                    @if($buku->kategori && $buku->kategori->rak)
                    <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-main);">
                        <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: var(--text-dimmed);">Letak Rak</p>
                        <p class="text-sm font-semibold" style="color: var(--text-primary);">{{ $buku->kategori->rak->nama_rak }} {{ $buku->kategori->rak->lokasi ? '('.$buku->kategori->rak->lokasi.')' : '' }}</p>
                    </div>
                    @endif
                    <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-main);">
                        <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: var(--text-dimmed);">Stok Tersedia</p>
                        @if($buku->stok > 0)
                        <p class="text-sm font-bold" style="color: var(--tag-green-text);">{{ $buku->stok }} buku</p>
                        @else
                        <p class="text-sm font-bold" style="color: var(--tag-red-text);">Habis</p>
                        @endif
                    </div>
                    <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-main);">
                        <p class="text-xs font-bold uppercase tracking-wider mb-1" style="color: var(--text-dimmed);">Masa Pinjam</p>
                        <p class="text-sm font-semibold" style="color: var(--text-primary);">7 hari</p>
                    </div>
                </div>

                <!-- Sinopsis -->
                @if($buku->deskripsi)
                <div class="mb-6">
                    <p class="text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--text-dimmed);">Sinopsis</p>
                    <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-main);">
                        <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">{{ $buku->deskripsi }}</p>
                    </div>
                </div>
                @endif

                <!-- Info Box -->
                <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background: var(--tag-indigo-bg); border: 1px solid rgba(99, 102, 241, 0.2);">
                    <div class="text-xl" style="color: var(--tag-indigo-text);">ℹ️</div>
                    <p class="text-xs font-medium" style="color: var(--tag-indigo-text);">
                        Tentukan sendiri kapan Anda akan mengembalikan buku ini. Denda keterlambatan sebesar Rp1.000/hari akan dikenakan jika Anda mengembalikan buku melampaui tanggal yang telah disepakati.
                    </p>
                </div>
                
                <!-- Action Button -->
                @if($buku->stok > 0)
                    <div class="flex items-center gap-3 flex-wrap">
                        <form action="{{ route('anggota.keranjang.tambah', $buku->id) }}" method="POST" class="flex gap-2 items-center">
                            @csrf
                            <label class="text-sm font-bold ml-1" style="color: var(--text-dimmed);">Jumlah:</label>
                            <input type="number" name="jumlah" value="1" min="1" max="{{ $buku->stok }}" class="w-20 px-3 py-3 rounded-xl text-sm text-center" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;">
                            <button type="submit" class="px-8 py-3 rounded-xl text-white font-bold text-sm transition-all hover:shadow-lg hover:-translate-y-0.5 inline-flex items-center gap-2" style="background: linear-gradient(135deg, #059669, #10b981);">
                                🛒 Tambah ke Keranjang
                            </button>
                        </form>
                        @if(count(session('keranjang', [])) > 0)
                        <a href="{{ route('anggota.keranjang') }}" class="px-6 py-3 rounded-xl text-sm font-semibold no-underline transition-all hover:opacity-80" style="color: var(--nav-active-text); border: 1.5px solid var(--border-input);">
                            Lihat Keranjang ({{ count(session('keranjang', [])) }})
                        </a>
                        @endif
                    </div>
                @else
                <button class="px-6 py-3 rounded-xl text-sm font-bold cursor-not-allowed" style="background: var(--bg-hover); color: var(--text-dimmed); border: none;" disabled>Stok Habis</button>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Floating Cart Badge --}}
@if(count(session('keranjang', [])) > 0)
<a href="{{ route('anggota.keranjang') }}" class="fixed bottom-6 right-6 z-50 flex items-center gap-2 px-5 py-3 rounded-full text-white font-bold text-sm shadow-2xl transition-all hover:scale-105 hover:shadow-xl no-underline"
   style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
    🛒 <span>Keranjang</span>
    <span class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-black" style="background: #ef4444;">{{ count(session('keranjang', [])) }}</span>
</a>
@endif
@endsection
