<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-2xl" style="color: var(--text-primary);">
                {{ __('Manajemen Kategori') }}
            </h2>
            <a href="{{ route('kategori.create') }}" class="inline-flex items-center gap-2 px-4 py-2 font-semibold text-sm rounded-lg text-white transition-all hover:-translate-y-0.5" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                
                @if(session('success'))
                    <div class="mx-6 mt-6 p-4 text-sm rounded-xl" role="alert" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border); color: var(--alert-success-text);">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mx-6 mt-6 p-4 text-sm rounded-xl" role="alert" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border); color: var(--alert-error-text);">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="p-6">
                    <div class="w-full">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase" style="color: var(--text-muted); border-bottom: 2px solid var(--border-main);">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-4 font-bold tracking-wider">Nama Kategori</th>
                                    <th scope="col" class="px-6 py-4 font-bold tracking-wider">Lokasi Default</th>
                                    <th scope="col" class="px-6 py-4 font-bold tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="color: var(--text-secondary);">
                                @forelse($kategoris as $index => $kategori)
                                    <tr class="transition-colors hover:bg-opacity-50" style="border-bottom: 1px solid var(--border-main); hover:background: var(--bg-hover);">
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-medium" style="color: var(--text-primary);">{{ $kategori->nama_kategori }}</td>
                                        <td class="px-6 py-4 text-sm" style="color: var(--text-secondary);">
                                            @if($kategori->rak)
                                                <span class="px-2.5 py-1 rounded-md" style="background: var(--tag-indigo-bg); color: var(--tag-indigo-text);">{{ $kategori->rak->nama_rak }}</span>
                                            @else
                                                <span style="color: var(--text-muted); font-style: italic;">Belum diatur</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-all" style="background: rgba(99, 102, 241, 0.1); color: #8b5cf6;">Edit</a>
                                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-all" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center" style="color: var(--text-muted);">Tidak ada daftar kategori ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
