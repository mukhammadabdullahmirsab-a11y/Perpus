@extends('layouts.anggota')

@section('content')
<div class="py-10 px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Card -->
        <div class="mb-8 p-8 rounded-2xl relative overflow-hidden" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            <div class="absolute top-0 right-0 w-64 h-64 rounded-full" style="background: radial-gradient(circle, var(--radial-1), transparent); transform: translate(30%, -30%);"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full" style="background: radial-gradient(circle, var(--radial-2), transparent); transform: translate(-30%, 30%);"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-black mb-2" style="color: var(--text-primary);">Halo, {{ $anggota->nama }}! 👋</h1>
                <p style="color: var(--text-muted);">Selamat datang di portal literatur perpustakaan digital. Siap membaca buku baru hari ini?</p>
            </div>
        </div>

        @if(isset($unpaidFines) && $unpaidFines->count() > 0)
        <!-- Alert Tagihan Denda -->
        <div class="mb-8 bg-red-50 border-l-4 border-red-500 flex p-4 rounded-xl shadow-sm">
            <div class="flex-shrink-0 mt-0.5">
                <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="ml-3 w-full">
                <h3 class="text-sm font-bold text-red-800">Perhatian: Anda memiliki tagihan denda belum lunas</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($unpaidFines as $uf)
                        <li>
                            Buku <strong>{{ $uf->buku->judul }}</strong> (Dikembalikan: {{ $uf->tanggal_kembali->format('d M Y') }})
                            <br>Tagihan: <strong>Rp {{ number_format($uf->denda_keterlambatan + $uf->denda_kerusakan, 0, ',', '.') }}</strong>
                        </li>
                        @endforeach
                    </ul>
                    <p class="mt-3 text-xs opacity-80 italic">Silakan hubungi petugas perpustakaan untuk melakukan pelunasan administrasi.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="p-5 rounded-xl hover:-translate-y-1 transition-transform" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-3" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider mb-1" style="color: var(--text-muted);">Buku Dipinjam</p>
                <h3 class="text-2xl font-black" style="color: var(--text-primary);">{{ $bukuDipinjam ?? 0 }}</h3>
            </div>
            
            <div class="p-5 rounded-xl hover:-translate-y-1 transition-transform" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-3" style="background: linear-gradient(135deg, #059669, #10b981);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider mb-1" style="color: var(--text-muted);">Telah Dikembalikan</p>
                <h3 class="text-2xl font-black" style="color: var(--text-primary);">{{ $bukuDikembalikan ?? 0 }}</h3>
            </div>
            
            <div class="p-5 rounded-xl hover:-translate-y-1 transition-transform" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center mb-3" style="background: linear-gradient(135deg, #7c3aed, #8b5cf6);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider mb-1" style="color: var(--text-muted);">Bergabung Pada</p>
                <h3 class="text-sm font-bold mt-1" style="color: var(--text-primary);">{{ $anggota->created_at->format('d M Y') }}</h3>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="mb-4 flex items-center gap-3">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #6366f1, #8b5cf6);"></div>
            <h4 class="text-base font-bold" style="color: var(--text-secondary);">Akses Cepat</h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <a href="{{ route('anggota.katalog') }}" class="block p-6 rounded-xl no-underline hover:-translate-y-1 transition-all duration-300" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                </div>
                <h5 class="text-lg font-bold mb-1" style="color: var(--text-primary);">Jelajah Katalog</h5>
                <p class="text-sm" style="color: var(--text-muted);">Temukan referensi buku impian Anda</p>
            </a>
            <a href="{{ route('anggota.riwayat') }}" class="block p-6 rounded-xl no-underline hover:-translate-y-1 transition-all duration-300" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h5 class="text-lg font-bold mb-1" style="color: var(--text-primary);">Riwayat Pinjam</h5>
                <p class="text-sm" style="color: var(--text-muted);">Pantau status masa tenggat dan denda</p>
            </a>
            <a href="{{ route('anggota.profile') }}" class="block p-6 rounded-xl no-underline hover:-translate-y-1 transition-all duration-300" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                </div>
                <h5 class="text-lg font-bold mb-1" style="color: var(--text-primary);">Pengaturan Profil</h5>
                <p class="text-sm" style="color: var(--text-muted);">Ubah data diri dan kelola Keamanan</p>
            </a>
        </div>
    </div>
</div>
@endsection
