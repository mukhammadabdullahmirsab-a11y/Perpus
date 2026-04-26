@extends('layouts.anggota')

@section('content')
<div class="py-10 px-6">
    <div class="max-w-7xl mx-auto">
        
        @if (session('success'))
        <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border);">
            <p style="color: var(--alert-success-text); text-sm font-medium">✅ {{ session('success') }}</p>
        </div>
        @endif
        @if (session('error'))
        <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
            <p style="color: var(--alert-error-text); text-sm font-medium">❌ {{ session('error') }}</p>
        </div>
        @endif
        
        <!-- Search -->
        <div class="mb-8 p-6 rounded-xl" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            <form action="{{ route('anggota.katalog') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full px-5 py-3 rounded-xl text-sm"
                           style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;"
                           placeholder="Cari judul buku, penulis, atau penerbit...">
                </div>
                <div class="sm:w-64">
                    <select name="kategori" class="w-full px-5 py-3 rounded-xl text-sm appearance-none" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 rounded-xl text-white font-semibold text-sm transition-all hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">Cari</button>
                @if(request('search') || request('kategori'))
                <a href="{{ route('anggota.katalog') }}" class="px-5 py-3 rounded-xl font-semibold text-sm no-underline flex items-center justify-center transition-all hover:opacity-80" style="color: var(--text-muted); border: 1.5px solid var(--border-input); background: var(--bg-hover);">Hapus Filter</a>
                @endif
            </form>
        </div>
        
        <!-- Results Info -->
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #6366f1, #8b5cf6);"></div>
                <h4 class="text-base font-bold" style="color: var(--text-secondary);">
                    @if(request('search')) Hasil: "{{ request('search') }}" @else Koleksi Buku @endif
                </h4>
            </div>
            <p style="color: var(--text-muted); font-size: 14px;">{{ $bukus->count() }} buku ditemukan</p>
        </div>
        
        @if($bukus->count() > 0)
            @foreach($groupedByRak as $namaRak => $kategoriGroup)
                @foreach($kategoriGroup as $namaKategori => $koleksi)
                <div class="mb-10">
                    <!-- Kategori Header -->
                    <div class="flex items-center gap-3 mb-4 pb-2" style="border-bottom: 1.5px solid var(--border-main);">
                        <div class="w-1.5 h-6 rounded-full" style="background: linear-gradient(180deg, #10b981, #059669);"></div>
                        <h3 class="text-lg font-bold m-0" style="color: var(--text-primary);">{{ $namaKategori }}</h3>
                        <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold" style="background: var(--bg-card); color: var(--text-muted); border: 1px solid var(--border-main);">{{ $koleksi->count() }} item</span>
                    </div>

                    <!-- Grid Buku per Kategori -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($koleksi as $buku)
                        <div class="rounded-xl overflow-hidden hover:-translate-y-2 transition-all duration-300 flex flex-col h-full group" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                            
                            <div class="w-full h-56 overflow-hidden relative" style="background: var(--bg-gradient-cover);">
                                <!-- Badge Rak -->
                                <div class="absolute top-3 right-3 flex flex-col gap-2 items-end z-10">
                                    @if($buku->kategori && $buku->kategori->rak)
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide backdrop-blur-md shadow-sm opacity-90 transition-opacity group-hover:opacity-100" style="background: rgba(245, 158, 11, 0.95); color: #fff;">Rak: {{ $buku->kategori->rak->nama_rak }}</span>
                                    @endif
                                </div>

                                @if($buku->cover_image)
                                    <img src="{{ asset('storage/' . $buku->cover_image) }}" alt="Cover {{ $buku->judul }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-5 flex-1 flex flex-col">
                                <h5 class="text-base font-bold mb-1 leading-tight line-clamp-2" style="color: var(--text-primary);" title="{{ $buku->judul }}">{{ $buku->judul }}</h5>
                                <p class="text-[13px] mb-3" style="color: var(--text-muted);">oleh <span style="color: var(--tag-indigo-text); font-weight: 500;">{{ $buku->penulis }}</span></p>
                                
                                @if($buku->deskripsi)
                                <p class="text-xs mb-4 leading-relaxed line-clamp-3" style="color: var(--text-dimmed);">{{ $buku->deskripsi }}</p>
                                @endif
                                
                                <div class="mt-auto pt-4 border-t flex items-center justify-between" style="border-color: var(--border-main);">
                                    <div>
                                        @if($buku->stok > 0)
                                        <p class="text-sm font-bold" style="color: var(--tag-green-text);">Stok: {{ $buku->stok }}</p>
                                        @else
                                        <p class="text-sm font-bold" style="color: var(--tag-red-text);">Stok Habis</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('anggota.katalog.detail', $buku->id) }}" class="p-2 rounded-lg transition-all hover:bg-gray-100 dark:hover:bg-gray-800" style="color: var(--text-primary); border: 1px solid var(--border-input);" title="Lihat Detail">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                                        </a>
                                        @if($buku->stok > 0)
                                        <form action="{{ route('anggota.keranjang.tambah', $buku->id) }}" method="POST" class="inline flex gap-2 items-center">
                                            @csrf
                                            <input type="number" name="jumlah" value="1" min="1" max="{{ $buku->stok }}" class="w-14 px-2 py-1 rounded-lg text-sm text-center" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;">
                                            <button type="submit" class="px-3 py-2 rounded-lg text-white font-medium text-xs transition-all hover:shadow-md hover:-translate-y-0.5" style="background: linear-gradient(135deg, #10b981, #059669);">
                                                + Keranjang
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endforeach
        @else
        <div class="text-center py-16 rounded-xl" style="background: var(--bg-card); border: 2px dashed var(--empty-border);">
            <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
            <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Buku Tidak Ditemukan</h3>
            <p style="color: var(--text-muted);">Coba gunakan kata kunci pencarian yang berbeda</p>
        </div>
        @endif
    </div>
</div>
@endsection
