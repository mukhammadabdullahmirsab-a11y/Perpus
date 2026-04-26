<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Anggota - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @include('layouts.theme')
</head>
<body class="flex items-center justify-center" style="min-height: 100vh;">
    
    <!-- Background -->
    <div style="position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none;">
        <div style="position: absolute; top: -10%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, var(--radial-1), transparent 70%); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -10%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, var(--radial-2), transparent 70%); border-radius: 50%;"></div>
    </div>
    
    <div class="w-full max-w-lg mx-auto px-4 relative" style="z-index: 10;">
        
        <!-- Theme Toggle (top-right) -->
        <div class="flex justify-end mb-4">
            @include('layouts.theme-toggle')
        </div>
        
        <div class="p-8 rounded-2xl" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" /></svg>
                </div>
                <h2 class="text-2xl font-black" style="color: var(--text-primary);">Register Akun</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Buat akun untuk mengakses perpustakaan</p>
            </div>
            
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
                <ul class="list-disc list-inside" style="color: var(--alert-error-text); font-size: 13px;">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
            @endif
            
            <form method="POST" action="{{ route('anggota.register.submit') }}">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold mb-2" style="color: var(--text-secondary);">NIS</label>
                        <input type="text" name="nis" value="{{ old('nis') }}" class="w-full px-4 py-3 rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;" placeholder="Nomor Induk" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2" style="color: var(--text-secondary);">Kelas</label>
                        <select name="kelas" class="w-full px-4 py-3 rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" required>
                            <option value="">Pilih Kelas</option>
                            @foreach(['X RPL 1','X RPL 2','XI RPL 1','XI RPL 2','XII RPL 1','XII RPL 2','X TKJ 1','XI TKJ 1','XII TKJ 1'] as $kelas)
                            <option value="{{ $kelas }}" {{ old('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-bold mb-2" style="color: var(--text-secondary);">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="w-full px-4 py-3 rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;" placeholder="Nama lengkap" required>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-bold mb-2" style="color: var(--text-secondary);">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;" placeholder="email@example.com" required>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold mb-2" style="color: var(--text-secondary);">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-3 rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;" placeholder="Min. 6 karakter" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-2" style="color: var(--text-secondary);">Konfirmasi</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;" placeholder="Ulangi password" required>
                    </div>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl text-white font-bold text-sm transition-all hover:shadow-lg" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">Daftar Sekarang</button>
            </form>
            
            <div class="text-center mt-6">
                <p style="color: var(--text-muted); font-size: 14px;">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold no-underline" style="color: var(--nav-active-text);">Masuk disini</a></p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
