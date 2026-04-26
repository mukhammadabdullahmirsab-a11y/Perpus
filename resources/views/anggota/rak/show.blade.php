@extends('layouts.anggota')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Back Button -->
        <a href="{{ route('anggota.rak.index') }}" class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5" style="background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-main);">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali ke Denah Rak
        </a>

        <!-- Header Info Rak -->
        <div class="mb-8 p-8 rounded-3xl relative overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            <div class="absolute inset-0 opacity-10 pointer-events-none" style="background: linear-gradient(135deg, #ec4899, #8b5cf6);"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 shadow-lg" style="background: linear-gradient(135deg, #ec4899, #db2777);">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h1 class="text-3xl font-black tracking-tight" style="color: var(--text-primary);">{{ $rak->nama_rak }}</h1>
                            @if($rak->lokasi)
                            <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-lg" style="background: var(--bg-hover); color: var(--text-secondary);">
                                {{ $rak->lokasi }}
                            </span>
                            @endif
                        </div>
                        <p style="color: var(--text-muted); font-size: 15px;">Daftar buku-buku yang tersimpan di bagian rak ini.</p>
                    </div>
                </div>
            </div>
        </div>

        @php
            $hasBooks = false;
        @endphp

        <!-- Konten per Kategori di dalam Rak -->
        <div class="space-y-10">
            @forelse($rak->kategoris as $kategori)
                @if($kategori->bukus->count() > 0)
                    @php $hasBooks = true; @endphp
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-2 h-8 rounded-full" style="background: linear-gradient(180deg, #10b981, #059669);"></div>
                            <h2 class="text-xl font-bold" style="color: var(--text-primary);">{{ $kategori->nama_kategori }}</h2>
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">{{ $kategori->bukus->count() }} Buku</span>
                        </div>
                        
                        <!-- Grid Buku -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                            @foreach($kategori->bukus as $buku)
                            <a href="{{ route('anggota.katalog.detail', $buku->id) }}" class="group flex flex-col rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-xl no-underline" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                                <div class="w-full h-48 sm:h-56 overflow-hidden relative" style="background: var(--bg-gradient-cover);">
                                    @if($buku->cover_image)
                                        <img src="{{ asset('storage/' . $buku->cover_image) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Badge Ketersediaan -->
                                    <div class="absolute top-3 right-3 z-10">
                                        @if($buku->stok > 0)
                                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md backdrop-blur-md shadow-sm" style="background: rgba(16, 185, 129, 0.9); color: white;">Tersedia</span>
                                        @else
                                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md backdrop-blur-md shadow-sm" style="background: rgba(239, 68, 68, 0.9); color: white;">Habis</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-4 flex-1 flex flex-col">
                                    <h4 class="font-bold text-sm sm:text-base leading-snug mb-1 line-clamp-2" style="color: var(--text-primary);">{{ $buku->judul }}</h4>
                                    <p class="text-xs mb-3" style="color: var(--text-muted);">{{ $buku->penulis }}</p>
                                    <div class="mt-auto pt-3 border-t flex justify-between items-center" style="border-color: var(--border-main);">
                                        <span class="text-xs font-semibold" style="color: var(--text-secondary);">Detail &raquo;</span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <!-- Loop Empty Handler (Will be caught by hasBooks later) -->
            @endforelse
            
            @if(!$hasBooks)
                <div class="p-12 rounded-2xl text-center" style="background: var(--bg-card); border: 2px dashed var(--border-main);">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-50" style="color: var(--text-muted);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                    <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Rak Masih Kosong</h3>
                    <p style="color: var(--text-muted);">Belum ada buku atau kategori yang dialokasikan ke rak ini.</p>
                </div>
            @endif
        </div>
        
    </div>
</div>
@endsection
