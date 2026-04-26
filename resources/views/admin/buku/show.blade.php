<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl" style="color: var(--text-primary);">{{ __('Detail Buku') }}</h2>
    </x-slot>

    <div class="py-10 px-4" style="min-height: 85vh;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border);">
                <p style="color: var(--alert-success-text); font-size: 13px; font-weight: 500;">✅ {{ session('success') }}</p>
            </div>
            @endif

            <!-- Back Button -->
            <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5" style="background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-main);">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                Kembali ke Katalog
            </a>

            <!-- Main Content Card -->
            <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
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

                <!-- Book Info (Below Image) -->
                <div class="p-8">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h1 class="text-3xl font-bold mb-2" style="color: var(--text-primary);">{{ $buku->judul }}</h1>
                            <p class="text-lg" style="color: var(--text-muted);">oleh <span class="font-semibold" style="color: var(--tag-indigo-text);">{{ $buku->penulis }}</span></p>
                        </div>
                        <span class="px-3 py-1.5 rounded-lg text-sm font-bold" style="background: {{ $buku->stok > 0 ? 'var(--tag-green-bg)' : 'var(--tag-red-bg)' }}; color: {{ $buku->stok > 0 ? 'var(--tag-green-text)' : 'var(--tag-red-text)' }};">
                            {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-input);">
                            <p class="text-xs font-semibold uppercase mb-1" style="color: var(--text-muted); letter-spacing: 0.05em;">Penerbit</p>
                            <p class="text-base font-bold" style="color: var(--text-primary);">{{ $buku->penerbit }}</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-input);">
                            <p class="text-xs font-semibold uppercase mb-1" style="color: var(--text-muted); letter-spacing: 0.05em;">Tahun Terbit</p>
                            <p class="text-base font-bold" style="color: var(--text-primary);">{{ $buku->tahun }}</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-input);">
                            <p class="text-xs font-semibold uppercase mb-1" style="color: var(--text-muted); letter-spacing: 0.05em;">Jumlah Stok</p>
                            <p class="text-base font-bold" style="color: var(--text-primary);">{{ $buku->stok }} eksemplar</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-input);">
                            <p class="text-xs font-semibold uppercase mb-1" style="color: var(--text-muted); letter-spacing: 0.05em;">Ditambahkan</p>
                            <p class="text-base font-bold" style="color: var(--text-primary);">{{ $buku->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Sinopsis -->
                    @if($buku->deskripsi)
                    <div class="mb-8">
                        <p class="text-xs font-semibold uppercase mb-2" style="color: var(--text-muted); letter-spacing: 0.05em;">Sinopsis</p>
                        <div class="p-4 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-input);">
                            <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">{{ $buku->deskripsi }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('buku.edit', $buku->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-white text-sm transition-all duration-200 hover:-translate-y-0.5" style="background: linear-gradient(135deg, #f59e0b, #d97706); border: none;">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                            Edit Buku
                        </a>
                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-white text-sm transition-all duration-200 hover:-translate-y-0.5" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none;">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                Hapus Buku
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
