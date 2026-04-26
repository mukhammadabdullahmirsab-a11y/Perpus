<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl" style="color: var(--text-primary);">
            {{ __('Pusat Kendali Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4" style="min-height: 85vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Hero Welcome -->
            <div class="mb-8 p-8 rounded-2xl relative overflow-hidden" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                <div class="absolute top-0 right-0 w-64 h-64 rounded-full opacity-100" style="background: radial-gradient(circle, var(--radial-1), transparent); transform: translate(30%, -30%);"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full opacity-100" style="background: radial-gradient(circle, var(--radial-2), transparent); transform: translate(-30%, 30%);"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-black mb-2" style="color: var(--text-primary);">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                    <p style="color: var(--text-muted);">Kelola koleksi buku dan pantau aktivitas sirkulasi dengan mudah hari ini.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="rounded-xl flex flex-col overflow-hidden transition-transform hover:-translate-y-1" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                    <div class="p-5 flex items-center gap-4 flex-1">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Total Buku</p>
                            <h3 class="text-2xl font-black" style="color: var(--text-primary);">{{ number_format($totalBuku) }}</h3>
                        </div>
                    </div>
                    <a href="{{ route('buku.index') }}" class="py-2 text-center text-xs font-bold uppercase tracking-wider transition-colors hover:bg-opacity-80" style="background: rgba(99, 102, 241, 0.1); color: #8b5cf6; border-top: 1px solid rgba(139, 92, 246, 0.2); display: block;">
                        Lihat Detail &rarr;
                    </a>
                </div>
                <div class="rounded-xl flex flex-col overflow-hidden transition-transform hover:-translate-y-1" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                    <div class="p-5 flex items-center gap-4 flex-1">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #7c3aed, #8b5cf6);">
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Anggota</p>
                            <h3 class="text-2xl font-black" style="color: var(--text-primary);">{{ number_format($totalAnggota) }}</h3>
                        </div>
                    </div>
                    <a href="{{ route('kelola-anggota.index') }}" class="py-2 text-center text-xs font-bold uppercase tracking-wider transition-colors hover:bg-opacity-80" style="background: rgba(124, 58, 237, 0.1); color: #8b5cf6; border-top: 1px solid rgba(139, 92, 246, 0.2); display: block;">
                        Lihat Detail &rarr;
                    </a>
                </div>
                <div class="rounded-xl flex flex-col overflow-hidden transition-transform hover:-translate-y-1" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                    <div class="p-5 flex items-center gap-4 flex-1">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #059669, #10b981);">
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Peminjaman</p>
                            <h3 class="text-2xl font-black" style="color: var(--text-primary);">{{ number_format($totalPeminjaman) }}</h3>
                        </div>
                    </div>
                    <a href="{{ route('transaksi.approval') }}" class="py-2 text-center text-xs font-bold uppercase tracking-wider transition-colors hover:bg-opacity-80" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border-top: 1px solid rgba(16, 185, 129, 0.2); display: block;">
                        Lihat Detail &rarr;
                    </a>
                </div>
                <div class="rounded-xl flex flex-col overflow-hidden transition-transform hover:-translate-y-1" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                    <div class="p-5 flex items-center gap-4 flex-1">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Terlambat</p>
                            <h3 class="text-2xl font-black" style="color: var(--text-primary);">{{ number_format($totalTerlambat) }}</h3>
                        </div>
                    </div>
                    <a href="{{ route('transaksi.approval') }}" class="py-2 text-center text-xs font-bold uppercase tracking-wider transition-colors hover:bg-opacity-80" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border-top: 1px solid rgba(239, 68, 68, 0.2); display: block;">
                        Lihat Detail &rarr;
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="mb-4 flex items-center gap-3">
                <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #6366f1, #8b5cf6);"></div>
                <h4 class="text-base font-bold" style="color: var(--text-secondary);">Akses Cepat</h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <a href="{{ route('buku.index') }}" class="block p-6 rounded-xl no-underline hover:-translate-y-1 transition-all duration-300 cursor-pointer" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);"><svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg></div>
                    <h5 class="text-lg font-bold mb-1" style="color: var(--text-primary);">Katalog Buku</h5>
                    <p class="text-sm mb-4" style="color: var(--text-muted);">Lihat, tambah, dan kelola semua koleksi buku perpustakaan.</p>
                    <div class="py-2 px-4 rounded-lg text-center text-white font-semibold text-sm" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">Buka →</div>
                </a>
                <a href="{{ route('transaksi.index') }}" class="block p-6 rounded-xl no-underline hover:-translate-y-1 transition-all duration-300 cursor-pointer" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #7c3aed, #8b5cf6);"><svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg></div>
                    <h5 class="text-lg font-bold mb-1" style="color: var(--text-primary);">Manajemen Transaksi</h5>
                    <p class="text-sm mb-4" style="color: var(--text-muted);">Kelola peminjaman dan pengembalian buku.</p>
                    <div class="py-2 px-4 rounded-lg text-center text-white font-semibold text-sm" style="background: linear-gradient(135deg, #7c3aed, #9333ea);">Buka →</div>
                </a>
                <a href="{{ route('kelola-anggota.index') }}" class="block p-6 rounded-xl no-underline hover:-translate-y-1 transition-all duration-300 cursor-pointer" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #059669, #10b981);"><svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg></div>
                    <h5 class="text-lg font-bold mb-1" style="color: var(--text-primary);">Manajemen Anggota</h5>
                    <p class="text-sm mb-4" style="color: var(--text-muted);">Kelola data pendaftaran dan status keanggotaan.</p>
                    <div class="py-2 px-4 rounded-lg text-center text-white font-semibold text-sm" style="background: linear-gradient(135deg, #10b981, #059669);">Buka →</div>
                </a>
                <a href="{{ route('admin.denda.index') }}" class="block p-6 rounded-xl no-underline hover:-translate-y-1 transition-all duration-300 cursor-pointer" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #f59e0b, #d97706);"><svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                    <h5 class="text-lg font-bold mb-1" style="color: var(--text-primary);">Rekapan Denda</h5>
                    <p class="text-sm mb-4" style="color: var(--text-muted);">Pantau dan kelola seluruh denda keterlambatan serta denda kerusakan buku.</p>
                    <div class="py-2 px-4 rounded-lg text-center text-white font-semibold text-sm" style="background: linear-gradient(135deg, #f59e0b, #d97706);">Buka →</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
