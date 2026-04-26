<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl" style="color: var(--text-primary);">{{ __('Edit Buku') }}</h2>
    </x-slot>

    <div class="py-10 px-4" style="min-height: 85vh;">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Back Button -->
            <a href="{{ route('buku.show', $buku->id) }}" class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5" style="background: var(--bg-card); color: var(--text-secondary); border: 1px solid var(--border-main);">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                Kembali ke Detail
            </a>

            <!-- Edit Form Card -->
            <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                <!-- Header -->
                <div class="p-5 flex items-center gap-3" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    <h3 class="text-lg font-bold text-white">Edit Buku: {{ $buku->judul }}</h3>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Current Cover Preview -->
                        <div class="mb-5">
                            <label class="form-label font-semibold mb-2 block" style="color: var(--text-secondary); font-size: 13px;">Cover Saat Ini</label>
                            @if($buku->cover_image)
                                <div class="w-40 h-56 rounded-xl overflow-hidden" style="border: 2px solid var(--border-main);">
                                    <img src="{{ asset('storage/' . $buku->cover_image) }}" alt="Cover {{ $buku->judul }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-40 h-56 rounded-xl flex items-center justify-center" style="background: var(--bg-gradient-cover); border: 2px dashed var(--border-main);">
                                    <svg class="w-12 h-12" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Upload New Cover -->
                        <div class="mb-5">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Ganti Cover Buku</label>
                            <input name="cover_image" type="file" accept="image/*" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-muted);">
                            <small style="color: var(--text-dimmed);">Format: JPG, PNG, WebP. Maks 2MB. Kosongkan jika tidak ingin mengganti.</small>
                            @error('cover_image') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Judul -->
                        <div class="mb-4">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Judul Buku</label>
                            <input name="judul" value="{{ old('judul', $buku->judul) }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Masukkan judul buku...">
                            @error('judul') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Penulis -->
                        <div class="mb-4">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Penulis</label>
                            <input name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Nama penulis...">
                            @error('penulis') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Penerbit -->
                        <div class="mb-4">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Penerbit</label>
                            <input name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Nama penerbit...">
                            @error('penerbit') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tahun & Stok -->
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Tahun</label>
                                <input name="tahun" type="number" value="{{ old('tahun', $buku->tahun) }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="2024">
                                @error('tahun') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Stok</label>
                                <input name="stok" type="number" value="{{ old('stok', $buku->stok) }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="0">
                                @error('stok') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Kategori  -->
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Kategori</label>
                                <select name="kategori_id" class="form-select rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                                    <option value="">Pilih Kategori (Opsional)</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id', $buku->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Sinopsis / Deskripsi</label>
                            <textarea name="deskripsi" rows="4" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Tuliskan sinopsis atau deskripsi buku...">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                            @error('deskripsi') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 mt-2">
                            <button type="submit" class="btn flex-1 rounded-xl py-3 font-bold text-white" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
                                💾 Simpan Perubahan
                            </button>
                            <a href="{{ route('buku.show', $buku->id) }}" class="btn rounded-xl py-3 font-bold px-5" style="background: var(--bg-input); color: var(--text-secondary); border: 1.5px solid var(--border-input);">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
