<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl" style="color: var(--text-primary);">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl p-6 sm:p-8" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-lg);">
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="nama_kategori" class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required class="w-full rounded-xl px-4 py-3 outline-none transition-all placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500/50" style="background: var(--bg-input); border: 1px solid var(--border-main); color: var(--text-primary);" placeholder="Masukkan nama kategori">
                        @error('nama_kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rak_id" class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Tentukan Lokasi Rak Default</label>
                        <select name="rak_id" id="rak_id" required class="w-full rounded-xl px-4 py-3 outline-none transition-all focus:ring-2 focus:ring-indigo-500/50" style="background: var(--bg-input); border: 1px solid var(--border-main); color: var(--text-primary);">
                            <option value="">-- Pilih Rak --</option>
                            @foreach($raks as $rak)
                                <option value="{{ $rak->id }}" {{ old('rak_id', $kategori->rak_id) == $rak->id ? 'selected' : '' }}>
                                    {{ $rak->nama_rak }} {{ $rak->lokasi ? '('.$rak->lokasi.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs mt-1" style="color: var(--text-muted);">Buku yang ditambahkan dengan kategori ini akan secara otomatis disusun pada Rak ini.</p>
                        @error('rak_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4" style="border-top: 1px solid var(--border-main);">
                        <a href="{{ route('kategori.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all" style="background: var(--bg-hover); color: var(--text-secondary);">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);">Perbarui Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
