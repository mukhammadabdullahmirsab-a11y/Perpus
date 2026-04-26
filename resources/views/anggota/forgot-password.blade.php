<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - Perpustakaan</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @include('layouts.theme')

    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px var(--bg-input) inset !important;
            -webkit-text-fill-color: var(--text-primary) !important;
            border: 1px solid var(--border-input) !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="flex items-center justify-center" style="min-height: 100vh;">
    
    <!-- Background -->
    <div style="position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none;">
        <div style="position: absolute; top: -10%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, var(--radial-1), transparent 70%); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -10%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, var(--radial-2), transparent 70%); border-radius: 50%;"></div>
    </div>
    
    <div class="w-full max-w-md p-6 relative" style="z-index: 10;">
        
        <!-- Theme Toggle -->
        <div class="flex justify-end mb-4">
            @include('layouts.theme-toggle')
        </div>

        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
            </div>
            <h1 class="text-2xl font-black" style="color: var(--text-primary);">Lupa Password?</h1>
            <p class="text-sm mt-1" style="color: var(--text-muted);">Verifikasi data akun anda</p>
        </div>
        
        <!-- Form Card -->
        <div class="rounded-2xl p-8" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
            
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
                <p style="color: var(--alert-error-text); font-size: 13px; font-weight: 500;">
                    ❌ {{ $errors->first() }}
                </p>
            </div>
            @endif
            
            <form method="POST" action="{{ route('anggota.password.verify') }}">
                @csrf
                
                <!-- NIS -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary);">Nomor Induk Siswa (NIS)</label>
                    <input type="text" name="nis" value="{{ old('nis') }}" 
                           class="w-full px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all"
                           style="background: var(--bg-input); border: 1px solid var(--border-input); color: var(--text-primary);"
                           placeholder="Contoh: 123456" required autofocus>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary);">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all"
                           style="background: var(--bg-input); border: 1px solid var(--border-input); color: var(--text-primary);"
                           placeholder="email@perpus.com" required>
                </div>
                
                <!-- Nama -->
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary);">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           class="w-full px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all"
                           style="background: var(--bg-input); border: 1px solid var(--border-input); color: var(--text-primary);"
                           placeholder="Sesuai pendaftaran" required>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-3.5 rounded-xl text-white font-bold text-base transition-all hover:shadow-lg hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                    Verifikasi Data
                </button>
            </form>

        </div>
        
        <!-- Back to Login Link -->
        <p class="text-center text-sm mt-5" style="color: var(--text-dimmed);">
            <a href="{{ route('anggota.login') }}" class="no-underline hover:opacity-80 font-semibold" style="color: var(--text-muted);">← Kembali ke Login</a>
        </p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
