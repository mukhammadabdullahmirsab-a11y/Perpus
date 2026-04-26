<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl" style="color: var(--text-primary);">Katalog Buku</h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Header Section -->
            <div class="p-6 rounded-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 4px 12px rgba(99,102,241,0.3);">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold" style="color: var(--text-primary);">Katalog Buku</h3>
                        <p class="text-sm" style="color: var(--text-muted);">Kelola semua koleksi buku perpustakaan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1.5 rounded-lg text-sm font-bold" style="background: var(--nav-active-bg); color: var(--nav-active-text);">{{ count($buku) }} Buku</span>
                    <button type="button" class="inline-flex items-center gap-2 btn px-4 py-2.5 rounded-xl font-bold text-white text-sm transition-all hover:-translate-y-0.5 hover:shadow-lg" data-bs-toggle="modal" data-bs-target="#tambahBukuModal" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none; box-shadow: 0 4px 12px rgba(99,102,241,0.3);">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Tambah Buku
                    </button>
                </div>
            </div>


            @if(session('success'))
            <div class="flex items-center gap-3 p-4 rounded-xl" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border);">
                <svg class="w-5 h-5 shrink-0" style="color: var(--alert-success-text);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="text-sm font-medium" style="color: var(--alert-success-text);">{{ session('success') }}</p>
            </div>
            @endif

            @if(count($buku) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($buku as $b)
                <div class="rounded-2xl overflow-hidden group card-hover flex flex-col" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                    <div class="w-full h-48 overflow-hidden relative" style="background: var(--bg-gradient-cover);">
                        @if($b->cover_image)
                            <img src="{{ asset('storage/' . $b->cover_image) }}" alt="Cover {{ $b->judul }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                            </div>
                        @endif
                        <!-- Stock badge overlay -->
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-1 rounded-lg text-xs font-bold" style="background: {{ $b->stok > 0 ? 'rgba(16,185,129,0.9)' : 'rgba(239,68,68,0.9)' }}; color: #fff; backdrop-filter: blur(8px);">{{ $b->stok > 0 ? 'Stok: '.$b->stok : 'Habis' }}</span>
                        </div>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <h4 class="text-base font-bold mb-1 line-clamp-2 leading-snug" style="color: var(--text-primary);">{{ $b->judul }}</h4>
                        <p class="text-sm mb-3" style="color: var(--text-muted);">oleh <span style="color: var(--tag-indigo-text); font-weight: 600;">{{ $b->penulis }}</span></p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="px-2 py-0.5 rounded-md text-xs font-semibold" style="background: var(--tag-indigo-bg); color: var(--tag-indigo-text);">{{ $b->tahun }}</span>
                            @if($b->kategori)
                                <span class="px-2 py-0.5 rounded-md text-xs font-semibold" style="background: rgba(16,185,129,0.1); color: #10b981;">{{ $b->kategori->nama_kategori }}</span>
                            @endif
                            @if($b->rak)
                                <span class="px-2 py-0.5 rounded-md text-xs font-semibold" style="background: rgba(245,158,11,0.1); color: #f59e0b;">{{ $b->rak->nama_rak }}</span>
                            @endif
                        </div>
                        <div class="mt-auto flex gap-2">
                            <a href="{{ route('buku.show', $b->id) }}" class="btn btn-sm flex-1 text-center px-3 py-2 rounded-xl text-xs font-bold transition-all hover:-translate-y-0.5" style="background: var(--tag-indigo-bg); color: var(--tag-indigo-text); border: 1px solid rgba(99,102,241,0.2); text-decoration: none;">Detail</a>
                            <a href="{{ route('buku.edit', $b->id) }}" class="btn btn-sm flex-1 text-center px-3 py-2 rounded-xl text-xs font-bold transition-all hover:-translate-y-0.5" style="background: var(--tag-yellow-bg); color: var(--tag-yellow-text); border: 1px solid rgba(245,158,11,0.2); text-decoration: none;">✏️ Edit</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-16 rounded-2xl text-center" style="background: var(--bg-card); border: 2px dashed var(--empty-border);">
                <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                <h4 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Koleksi Kosong</h4>
                <p class="mb-6" style="color: var(--text-muted);">Belum ada buku dalam perpustakaan.</p>
                <button class="btn px-6 py-3 rounded-xl font-bold text-white" data-bs-toggle="modal" data-bs-target="#tambahBukuModal" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">+ Tambah Buku Pertama</button>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah Buku -->
    <div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="tambahBukuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 overflow-hidden" style="background: var(--dropdown-bg); border-radius: 16px;">
                <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <h5 class="modal-title font-bold text-white" id="tambahBukuModalLabel">Tambah Buku Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5">
                    <form action="/buku" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Judul Buku</label>
                            <input name="judul" value="{{ old('judul') }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Masukkan judul buku...">
                            @error('judul') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Penulis</label>
                            <input name="penulis" value="{{ old('penulis') }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Nama penulis...">
                        </div>
                        <div class="mb-4">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Penerbit</label>
                            <input name="penerbit" value="{{ old('penerbit') }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Nama penerbit...">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Tahun</label>
                                <input name="tahun" type="number" value="{{ old('tahun') }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="2024">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Stok</label>
                                <input name="stok" type="number" value="{{ old('stok') }}" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Kategori</label>
                                <select name="kategori_id" class="form-select rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                                    <option value="">Pilih Kategori (Opsional)</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Sinopsis / Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Tuliskan sinopsis atau deskripsi buku...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label font-semibold" style="color: var(--text-secondary); font-size: 13px;">Gambar Cover Buku</label>
                            <input name="cover_image" type="file" accept="image/*" class="form-control rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-muted);">
                            <small style="color: var(--text-dimmed);">Format: JPG, PNG, WebP. Maks 2MB</small>
                            @error('cover_image') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn w-100 rounded-xl py-3 font-bold text-white" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">Simpan Buku</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
