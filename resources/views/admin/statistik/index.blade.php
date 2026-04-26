<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-2xl" style="color: var(--text-primary);">
                {{ __('Laporan Statistik Perpustakaan') }}
            </h2>
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider" style="background: var(--tag-indigo-bg); color: var(--tag-indigo-text);">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                Ringkasan Data
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Filters Section -->
            <div class="rounded-2xl p-6 shadow-sm border transition-all" style="background: var(--bg-card); border-color: var(--border-main);">
                <form action="{{ route('admin.statistik') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-bold uppercase mb-2 tracking-widest" style="color: var(--text-muted);">Pilih Periode</label>
                        <select name="periode" id="periode-select" onchange="toggleCustomDates()" class="w-full rounded-xl px-4 py-2.5 outline-none transition-all focus:ring-2 focus:ring-indigo-500/50" style="background: var(--bg-input); border: 1px solid var(--border-main); color: var(--text-primary);">
                            <option value="all_time" {{ $filter == 'all_time' ? 'selected' : '' }}>Seluruh Waktu</option>
                            <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="this_month" {{ $filter == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="this_year" {{ $filter == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                            <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Rentang Kustom</option>
                        </select>
                    </div>

                    <div id="custom-dates" class="{{ $filter == 'custom' ? 'flex' : 'hidden' }} items-end gap-3 flex-wrap">
                        <div class="min-w-[150px]">
                            <label class="block text-xs font-bold uppercase mb-2 tracking-widest" style="color: var(--text-muted);">Dari</label>
                            <input type="date" name="from" value="{{ request('from') }}" class="w-full rounded-xl px-4 py-2 outline-none transition-all focus:ring-2 focus:ring-indigo-500/50" style="background: var(--bg-input); border: 1px solid var(--border-main); color: var(--text-primary);">
                        </div>
                        <div class="min-w-[150px]">
                            <label class="block text-xs font-bold uppercase mb-2 tracking-widest" style="color: var(--text-muted);">Sampai</label>
                            <input type="date" name="to" value="{{ request('to') }}" class="w-full rounded-xl px-4 py-2 outline-none transition-all focus:ring-2 focus:ring-indigo-500/50" style="background: var(--bg-input); border: 1px solid var(--border-main); color: var(--text-primary);">
                        </div>
                    </div>

                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:scale-105 active:scale-95" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);">
                        Terapkan Filter
                    </button>
                    @if($filter != 'all_time' || request()->has('from'))
                        <a href="{{ route('admin.statistik') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all" style="background: var(--bg-hover); color: var(--text-secondary);">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Bar Chart Visualization -->
            <div class="rounded-2xl p-6 shadow-sm border" style="background: var(--bg-card); border-color: var(--border-main);">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-lg" style="color: var(--text-primary);">Grafik Buku Terpopuler</h3>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    </div>
                </div>
                <div class="relative w-full" style="height: 350px;">
                    @if($topBooks->count() > 0)
                        <canvas id="topBooksChart"></canvas>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-sm font-medium" style="color: var(--text-dimmed);">Tidak ada data peminjaman di periode ini.</div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- 1. Buku Paling Banyak Dipinjam -->
                <div class="rounded-2xl overflow-hidden shadow-sm border h-fit" style="background: var(--bg-card); border-color: var(--border-main);">
                    <div class="p-6 flex items-center justify-between" style="border-bottom: 1px solid var(--border-main);">
                        <h3 class="font-bold text-lg" style="color: var(--text-primary);">Buku Terpopuler</h3>
                        <span class="px-3 py-1 text-xs font-bold rounded-full" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">Top 10</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase tracking-widest" style="background: var(--bg-hover); color: var(--text-muted);">
                                <tr>
                                    <th class="px-6 py-4">Judul Buku</th>
                                    <th class="px-6 py-4 text-center">Total Pinjam</th>
                                </tr>
                            </thead>
                            <tbody style="color: var(--text-secondary);">
                                @forelse($topBooks as $bookDetail)
                                    <tr class="border-b transition-colors hover:bg-opacity-30" style="border-color: var(--border-main); hover:background: var(--bg-hover);">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold" style="color: var(--text-primary);">{{ $bookDetail->buku->judul ?? 'N/A' }}</div>
                                            <div class="text-xs" style="color: var(--text-dimmed);">{{ $bookDetail->buku->penulis ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1.5 rounded-lg font-black" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                                                {{ $bookDetail->total }} x
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-8 text-center" style="color: var(--text-dimmed);">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Buku yang Jarang Dipinjam -->
                <div class="rounded-2xl overflow-hidden shadow-sm border h-fit" style="background: var(--bg-card); border-color: var(--border-main);">
                    <div class="p-6 flex items-center justify-between" style="border-bottom: 1px solid var(--border-main);">
                        <h3 class="font-bold text-lg" style="color: var(--text-primary);">Buku Jarang Dipinjam</h3>
                        <span class="px-3 py-1 text-xs font-bold rounded-full" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">Review Stok</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase tracking-widest" style="background: var(--bg-hover); color: var(--text-muted);">
                                <tr>
                                    <th class="px-6 py-4">Judul Buku</th>
                                    <th class="px-6 py-4 text-center">Total Pinjam</th>
                                </tr>
                            </thead>
                            <tbody style="color: var(--text-secondary);">
                                @forelse($bottomBooks as $bookDetail)
                                    <tr class="border-b transition-colors hover:bg-opacity-30" style="border-color: var(--border-main); hover:background: var(--bg-hover);">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold" style="color: var(--text-primary);">{{ $bookDetail->buku->judul ?? 'N/A' }}</div>
                                            <div class="text-xs" style="color: var(--text-dimmed);">{{ $bookDetail->buku->penulis ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1.5 rounded-lg font-black" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                                                {{ $bookDetail->total }} x
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-8 text-center" style="color: var(--text-dimmed);">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 3. Statistik per Kategori -->
            <div class="rounded-2xl overflow-hidden shadow-sm border" style="background: var(--bg-card); border-color: var(--border-main);">
                <div class="p-6" style="border-bottom: 1px solid var(--border-main);">
                    <h3 class="font-bold text-lg" style="color: var(--text-primary);">Populasi Peminjaman per Kategori</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase tracking-widest" style="background: var(--bg-hover); color: var(--text-muted);">
                            <tr>
                                <th class="px-6 py-4">Nama Kategori</th>
                                <th class="px-6 py-4 text-right">Frekuensi Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody style="color: var(--text-secondary);">
                            @forelse($categoryData as $data)
                                <tr class="border-b transition-colors hover:bg-opacity-30" style="border-color: var(--border-main); hover:background: var(--bg-hover);">
                                    <td class="px-6 py-4 font-bold" style="color: var(--text-primary);">{{ $data->nama_kategori }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="px-3 py-1 rounded-md text-white font-bold" style="background: #8b5cf6;">{{ $data->total }} kali</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center" style="color: var(--text-dimmed);">Data kategori belum tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function toggleCustomDates() {
            const select = document.getElementById('periode-select');
            const customBox = document.getElementById('custom-dates');
            if (select.value === 'custom') {
                customBox.classList.remove('hidden');
                customBox.classList.add('flex');
            } else {
                customBox.classList.add('hidden');
                customBox.classList.remove('flex');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Theme colors from CSS variables helper
            const getThemeColor = (variable) => getComputedStyle(document.documentElement).getPropertyValue(variable).trim();
            const mutedColor = getThemeColor('--text-muted') || '#666';
            const borderColor = getThemeColor('--border-main') || 'rgba(0,0,0,0.1)';

            // Top Books Chart
            @if($topBooks->count() > 0)
            const ctx = document.getElementById('topBooksChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($topBooks->map(fn($b) => \Illuminate\Support\Str::limit($b->buku->judul ?? '?', 15))->toArray()) !!},
                        datasets: [{
                            label: 'Kali Dipinjam',
                            data: {!! json_encode($topBooks->map->total->toArray()) !!},
                            backgroundColor: 'rgba(99, 102, 241, 0.6)',
                            borderColor: '#6366f1',
                            borderWidth: 2,
                            borderRadius: 8
                        }]
                    },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#1e293b', titleColor: '#fff', bodyColor: '#cbd5e1' }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            ticks: { color: mutedColor },
                            grid: { color: borderColor }
                        },
                        x: { 
                            ticks: { color: mutedColor },
                            grid: { display: false }
                        }
                    }
                }
            });
            @endif
        });
    </script>
    @endpush
</x-app-layout>
