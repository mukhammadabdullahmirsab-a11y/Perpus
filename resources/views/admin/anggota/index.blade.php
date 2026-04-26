<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-xl" style="color: var(--text-primary);">Manajemen Anggota</h2>
            <a href="{{ route('kelola-anggota.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-white text-sm font-bold transition-all hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 4px 12px rgba(99,102,241,0.3);">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Tambah Anggota
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Alerts -->
            @if (session('success'))
            <div class="flex items-center gap-3 p-4 rounded-xl" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border);">
                <svg class="w-5 h-5 shrink-0" style="color: var(--alert-success-text);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="text-sm font-medium" style="color: var(--alert-success-text);">{{ session('success') }}</p>
            </div>
            @endif
            @if (session('error'))
            <div class="flex items-center gap-3 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
                <svg class="w-5 h-5 shrink-0" style="color: var(--alert-error-text);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                <p class="text-sm font-medium" style="color: var(--alert-error-text);">{{ session('error') }}</p>
            </div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="p-5 rounded-xl flex items-center gap-4" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Total Anggota</p>
                        <p class="text-2xl font-black" style="color: var(--text-primary);">{{ $anggotas->count() }}</p>
                    </div>
                </div>
                <div class="p-5 rounded-xl flex items-center gap-4" style="background: var(--bg-card); border: 1px solid rgba(99,102,241,0.3); box-shadow: var(--shadow-sm);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--tag-indigo-text);">Jumlah Kelas</p>
                        <p class="text-2xl font-black" style="color: var(--tag-indigo-text);">{{ $kelasList->count() }}</p>
                    </div>
                </div>
                <div class="p-5 rounded-xl flex items-center gap-4" style="background: var(--bg-card); border: 1px solid rgba(34,197,94,0.3); box-shadow: var(--shadow-sm);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--tag-green-text);">Anggota Aktif</p>
                        <p class="text-2xl font-black" style="color: var(--tag-green-text);">{{ $anggotas->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="p-5 rounded-2xl" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                <form action="{{ route('kelola-anggota.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-end">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Cari Anggota</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm"
                               style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);"
                               placeholder="Nama, NIS, atau email...">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Kelas</label>
                        <select name="kelas" class="px-4 py-2.5 rounded-xl text-sm" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                            <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-white text-sm font-bold transition-all hover:-translate-y-0.5 hover:shadow-md" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        Filter
                    </button>
                    @if(request('search') || request('kelas'))
                    <a href="{{ route('kelola-anggota.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all hover:opacity-80 text-center" style="background: var(--bg-hover); color: var(--text-secondary); border: 1px solid var(--border-main);">
                        Reset
                    </a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom: 1px solid var(--border-main);">
                    <div class="w-1 h-5 rounded-full" style="background: linear-gradient(180deg, #6366f1, #8b5cf6);"></div>
                    <h3 class="font-bold text-sm" style="color: var(--text-primary);">Daftar Anggota</h3>
                    <span class="ml-auto text-xs font-medium px-2.5 py-1 rounded-full" style="background: var(--bg-hover); color: var(--text-muted);">{{ $anggotas->count() }} data</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead style="background: var(--bg-table-head);">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">No</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">NIS</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Nama</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Kelas</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Email</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Peminjaman</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggotas as $index => $anggota)
                            <tr style="border-bottom: 1px solid var(--border-main);">
                                <td class="px-5 py-4 text-sm" style="color: var(--text-muted);">{{ $index + 1 }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-full" style="background: var(--tag-indigo-bg); color: var(--tag-indigo-text); border: 1px solid rgba(99,102,241,0.2);">{{ $anggota->nis }}</span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                            {{ substr($anggota->nama, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-semibold" style="color: var(--text-primary);">{{ $anggota->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md" style="background: var(--bg-hover); color: var(--text-secondary);">{{ $anggota->kelas }}</span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-sm" style="color: var(--text-secondary);">{{ $anggota->email }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @php $activePinjam = $anggota->transaksis()->where('status', 'dipinjam')->count(); @endphp
                                    @if($activePinjam > 0)
                                    <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-full" style="background: var(--tag-yellow-bg); color: var(--tag-yellow-text); border: 1px solid rgba(245,158,11,0.3);">{{ $activePinjam }} buku</span>
                                    @else
                                    <span class="text-sm" style="color: var(--text-dimmed);">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('kelola-anggota.edit', $anggota->id) }}" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all hover:-translate-y-0.5" style="background: var(--tag-indigo-bg); color: var(--tag-indigo-text); border: 1px solid rgba(99,102,241,0.3);">Edit</a>
                                        <form action="{{ route('kelola-anggota.destroy', $anggota->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-xs font-bold rounded-lg transition-all hover:-translate-y-0.5" style="background: var(--tag-red-bg); color: var(--tag-red-text); border: 1px solid rgba(239,68,68,0.3);" onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <svg class="w-12 h-12 mx-auto mb-3" style="color: var(--placeholder-icon);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                                    <p class="text-sm font-medium" style="color: var(--text-muted);">Tidak ada data anggota</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
