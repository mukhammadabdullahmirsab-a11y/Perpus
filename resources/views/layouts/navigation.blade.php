<!-- Sidebar Component -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 transition-transform duration-300 transform -translate-x-full sm:translate-x-0 sm:static sm:inset-0 flex flex-col h-screen" style="background: var(--bg-card); border-right: 1px solid var(--border-main); box-shadow: var(--shadow-lg);">
    
    <!-- Sidebar Header (Logo) -->
    <div class="h-16 flex items-center px-6 flex-shrink-0" style="border-bottom: 1px solid var(--border-main);">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 no-underline w-full">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);">
                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
            </div>
            <div class="flex flex-col">
                <span class="font-bold text-sm leading-tight tracking-wide" style="color: var(--text-primary);">Perpustakaan</span>
                <span class="text-[10px] font-medium" style="color: var(--text-muted); letter-spacing: 0.05em;">ADMIN PANEL</span>
            </div>
        </a>
        <!-- Close Button mobile -->
        <button onclick="document.getElementById('sidebar').classList.add('-translate-x-full')" class="sm:hidden p-1 ms-auto rounded-md focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" style="color: var(--text-muted); hover:color: var(--text-primary);">
            <span class="sr-only">Close sidebar</span>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Scrollable Menu -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6 scrollbar-thin">
        
        <!-- Menu Section: Utama -->
        <div>
            <p class="px-3 mb-2 text-xs font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Utama</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                   style="{{ request()->routeIs('dashboard') ? 'background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1)); color: var(--tag-indigo-text); border: 1px solid rgba(99, 102, 241, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.statistik') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                   style="{{ request()->routeIs('admin.statistik') ? 'background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1)); color: var(--tag-indigo-text); border: 1px solid rgba(99, 102, 241, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
                    Statistik
                </a>
                <a href="{{ route('laporan.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                   style="{{ request()->routeIs('laporan.*') ? 'background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1)); color: var(--tag-indigo-text); border: 1px solid rgba(99, 102, 241, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    Laporan Cetak
                </a>
            </div>
        </div>

        <!-- Menu Section: Koleksi -->
        <div>
            <p class="px-3 mb-2 text-xs font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Perpustakaan</p>
            <div class="space-y-1">
                <a href="{{ route('buku.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                   style="{{ request()->routeIs('buku.*') ? 'background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1)); color: var(--tag-green-text); border: 1px solid rgba(16, 185, 129, 0.2);' : 'color: var(--text-secondary); border: 1px solid transparent;' }}">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                    Katalog Buku
                </a>
                <a href="{{ route('kategori.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                   style="{{ request()->routeIs('kategori.*') ? 'background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1)); color: var(--tag-indigo-text); border: 1px solid rgba(99, 102, 241, 0.2);' : 'color: var(--text-secondary); border: 1px solid transparent;' }}">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                    Data Kategori
                </a>
                <a href="{{ route('rak.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                   style="{{ request()->routeIs('rak.*') ? 'background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1)); color: var(--tag-yellow-text); border: 1px solid rgba(245, 158, 11, 0.2);' : 'color: var(--text-secondary); border: 1px solid transparent;' }}">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125" /></svg>
                    Rak Buku
                </a>
            </div>
        </div>

        <!-- Menu Section: Transaksi -->
        <div>
            <p class="px-3 mb-2 text-xs font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Peminjaman</p>
            <div class="space-y-1">
                <a href="{{ route('transaksi.approval') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5 justify-between"
                   style="{{ request()->routeIs('transaksi.approval') ? 'background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1)); color: var(--tag-red-text); border: 1px solid rgba(239, 68, 68, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        Approval Pinjam
                    </div>
                    @php
                        $pendingCount = \App\Models\Transaksi::where('status', 'menunggu')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white rounded-lg shadow-sm" style="background: linear-gradient(135deg, #ef4444, #dc2626); min-width: 24px;">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('transaksi.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                   style="{{ request()->routeIs('transaksi.index') || request()->routeIs('transaksi.create') || request()->routeIs('transaksi.edit') ? 'background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1)); color: var(--tag-yellow-text); border: 1px solid rgba(245, 158, 11, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 011.875 1.875v11.25a1.875 1.875 0 01-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V6.375A1.875 1.875 0 015.625 4.5z" /></svg>
                    Riwayat Detail
                </a>
                <a href="{{ route('admin.denda.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                   style="{{ request()->routeIs('admin.denda.index') ? 'background: linear-gradient(135deg, rgba(f, 9e, 0b, 0.1), rgba(d, 97, 06, 0.1)); color: #f59e0b; border: 1px solid rgba(f, 9e, 0b, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Rekapan Denda
                </a>
            </div>
        </div>

        <!-- Menu Section: Akun -->
        <div>
            <p class="px-3 mb-2 text-xs font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Keanggotaan</p>
            <div class="space-y-1">
                <a href="{{ route('kelola-anggota.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                   style="{{ request()->routeIs('kelola-anggota.*') ? 'background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.1)); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    Data Anggota
                </a>
            </div>
        </div>
    </div>

    <!-- Sidebar Footer / Logout -->
    <div class="p-4 mt-auto" style="border-top: 1px solid var(--border-main);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white transition-all duration-300 hover:shadow-md hover:-translate-y-0.5" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                Sign Out Admin
            </button>
        </form>
    </div>
</aside>

