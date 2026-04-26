@extends('layouts.anggota')

@section('content')
<div class="py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold mb-2" style="color: var(--text-primary); letter-spacing: -0.02em;">Jelajah Denah Rak</h1>
                <p class="text-base" style="color: var(--text-muted);">Mari telusuri letak buku kesukaanmu dari keseluruhan rak yang ada di perpustakaan kami.</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 rounded-xl" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                <svg class="w-5 h-5" style="color: var(--tag-indigo-text);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>
                <span class="font-bold text-sm" style="color: var(--text-primary);">Total: {{ count($raks) }} Unit Rak</span>
            </div>
        </div>

        @if(count($raks) > 0)
        <!-- Grid Rak -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($raks as $rak)
            <a href="{{ route('anggota.rak.show', $rak->id) }}" class="group block relative rounded-2xl p-6 transition-all duration-300 hover:-translate-y-2 no-underline" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                <!-- Dekorasi Visual Gradient -->
                <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none" style="background: linear-gradient(135deg, rgba(236, 72, 153, 0.05), rgba(219, 39, 119, 0.05)); z-index: 0;"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-inner" style="background: linear-gradient(135deg, #ec4899, #db2777); color: white;">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>
                        </div>
                        @if($rak->lokasi)
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg" style="background: var(--bg-hover); color: var(--text-secondary);">
                            {{ $rak->lokasi }}
                        </span>
                        @endif
                    </div>
                    
                    <h3 class="text-xl font-bold mb-1" style="color: var(--text-primary);">{{ $rak->nama_rak }}</h3>
                    
                    @php
                        $totalBuku = 0;
                        $kategoriNames = [];
                        foreach($rak->kategoris as $kategori) {
                            $totalBuku += $kategori->bukus->count();
                            $kategoriNames[] = $kategori->nama_kategori;
                        }
                    @endphp
                    
                    <div class="mt-4 pt-4 flex flex-col gap-2" style="border-top: 1px dashed var(--border-main);">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                            <span class="text-sm font-semibold" style="color: var(--text-secondary);">{{ $totalBuku }} Buku</span>
                        </div>
                        @if(count($kategoriNames) > 0)
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach(array_slice($kategoriNames, 0, 3) as $katName)
                                <span class="text-[10px] px-2 py-0.5 rounded-md font-medium" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">{{ $katName }}</span>
                            @endforeach
                            @if(count($kategoriNames) > 3)
                                <span class="text-[10px] px-2 py-0.5 rounded-md font-medium" style="background: var(--bg-hover); color: var(--text-muted);">+{{ count($kategoriNames) - 3 }}</span>
                            @endif
                        </div>
                        @else
                        <span class="text-xs italic mt-1" style="color: var(--text-muted);">Belum ada alokasi kategori</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="p-12 rounded-2xl text-center mt-8" style="background: var(--bg-card); border: 2px dashed var(--border-main);">
            <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>
            <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Belum Ada Rak</h3>
            <p style="color: var(--text-muted);">Administrator belum menambahkan letak penempatan fisik rak.</p>
        </div>
        @endif
    </div>
</div>
@endsection
