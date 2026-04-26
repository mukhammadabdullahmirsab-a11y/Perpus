<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Anggota - Perpustakaan</title>
    <!-- Tailwind & Default Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @include('layouts.theme')
</head>
<body class="antialiased" style="background: var(--bg-main);">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Anggota -->
        <aside id="sidebar-anggota" class="fixed inset-y-0 left-0 z-30 w-64 transition-transform duration-300 transform -translate-x-full sm:translate-x-0 sm:static sm:inset-0 flex flex-col h-screen" style="background: var(--bg-card); border-right: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 flex-shrink-0" style="border-bottom: 1px solid var(--border-main);">
                <a href="{{ route('anggota.dashboard') }}" class="flex items-center gap-3 no-underline w-full">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);">
                        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-sm leading-tight tracking-wide" style="color: var(--text-primary);">Perpustakaan</span>
                        <span class="text-[10px] font-medium" style="color: var(--text-muted); letter-spacing: 0.05em;">PORTAL ANGGOTA</span>
                    </div>
                </a>
                <button onclick="document.getElementById('sidebar-anggota').classList.add('-translate-x-full')" class="sm:hidden p-1 ms-auto rounded-md focus:outline-none" style="color: var(--text-muted); hover:color: var(--text-primary);">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menu Aktif -->
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6 scrollbar-thin">
                
                <div>
                    <p class="px-3 mb-2 text-xs font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Utama</p>
                    <div class="space-y-1">
                        <a href="{{ route('anggota.dashboard') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                           style="{{ request()->routeIs('anggota.dashboard') ? 'background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1)); color: var(--tag-green-text); border: 1px solid rgba(16, 185, 129, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('anggota.katalog') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                           style="{{ request()->routeIs('anggota.katalog') || request()->routeIs('anggota.buku.*') ? 'background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1)); color: var(--tag-indigo-text); border: 1px solid rgba(99, 102, 241, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                            Katalog Buku
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-3 mb-2 text-xs font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Aktivitas Ku</p>
                    <div class="space-y-1">
                        <a href="{{ route('anggota.riwayat') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                           style="{{ request()->routeIs('anggota.riwayat') ? 'background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1)); color: var(--tag-yellow-text); border: 1px solid rgba(245, 158, 11, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Riwayat Pinjam
                        </a>
                        <a href="{{ route('anggota.keranjang') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                           style="{{ request()->routeIs('anggota.keranjang') ? 'background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1)); color: var(--tag-indigo-text); border: 1px solid rgba(99, 102, 241, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                            Keranjang
                            @if(count(session('keranjang', [])) > 0)
                            <span class="ml-auto flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-black text-white" style="background: #ef4444;">{{ count(session('keranjang', [])) }}</span>
                            @endif
                        </a>
                        <a href="{{ route('anggota.denda.index') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                           style="{{ request()->routeIs('anggota.denda.index') ? 'background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1)); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Rekapan Denda
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-3 mb-2 text-xs font-bold uppercase tracking-wider" style="color: var(--text-dimmed);">Akun</p>
                    <div class="space-y-1">
                        <a href="{{ route('anggota.profile') }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium no-underline transition-all duration-200 hover:-translate-y-0.5"
                           style="{{ request()->routeIs('anggota.profile') ? 'background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.1)); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2);' : 'color: var(--text-secondary); hover:background: var(--bg-hover); border: 1px solid transparent;' }}">
                            <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            Profil Saya
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar Footer -->
            <div class="p-4 mt-auto" style="border-top: 1px solid var(--border-main);">
                <form action="{{ route('anggota.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 hover:shadow-md hover:-translate-y-0.5" style="color: var(--btn-ghost-text); background: var(--bg-hover); border: 1px solid var(--border-main);">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Anggota -->
        <div class="flex-1 flex flex-col overflow-y-auto w-full transition-all duration-300" id="main-content-anggota">
            <!-- Topbar -->
            <header class="sticky top-0 z-20 px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between transition-all" style="background: var(--bg-nav); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-main);">
                <div class="flex items-center gap-4 sm:hidden">
                    <button onclick="document.getElementById('sidebar-anggota').classList.toggle('-translate-x-full'); document.getElementById('main-content-anggota').classList.toggle('sm:ml-64')" class="p-2 rounded-lg" style="color: var(--text-muted); hover:background: var(--bg-hover);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>

                <div class="hidden sm:block">
                    <!-- Space for optional Topbar Title -->
                </div>

                <div class="flex items-center gap-3 ms-auto">
                    @include('layouts.theme-toggle')
                    @php $usr = Auth::guard('anggota')->user(); @endphp
                    @if($usr)
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                        <div class="w-6 h-6 rounded flex items-center justify-center text-xs font-bold text-white shadow-sm" style="background: linear-gradient(135deg, #10b981, #059669);">
                            {{ substr($usr->nama, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium hidden sm:inline-block" style="color: var(--text-secondary);">{{ $usr->nama }}</span>
                    </div>
                    @endif
                </div>
            </header>

            <!-- Detail Yield Content -->
            <main class="flex-1 w-full relative">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
