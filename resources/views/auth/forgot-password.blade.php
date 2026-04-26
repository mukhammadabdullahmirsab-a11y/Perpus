<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password Admin - Perpustakaan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @include('layouts.theme')
</head>
<body class="flex items-center justify-center" style="min-height: 100vh;">
    
    <div style="position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none;">
        <div style="position: absolute; top: -10%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, var(--radial-1), transparent 70%); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -10%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, var(--radial-2), transparent 70%); border-radius: 50%;"></div>
    </div>
    
    <div class="w-full max-w-md mx-auto px-4 relative" style="z-index: 10;">
        
        <div class="flex justify-end mb-4">
            @include('layouts.theme-toggle')
        </div>

        <div class="p-8 rounded-2xl" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
            
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                </div>
                <h2 class="text-2xl font-black" style="color: var(--text-primary);">LUPA SANDI</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Verifikasi data admin Anda</p>
            </div>
            
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
                <p style="color: var(--alert-error-text); font-size: 13px; font-weight: 500;">
                    ❌ {{ $errors->first() }}
                </p>
            </div>
            @endif
            
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-xs font-bold mb-2" style="color: var(--text-secondary);">Email Admin</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500"
                           style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);"
                           placeholder="email@example.com" required autofocus>
                </div>
                
                <div class="mb-6">
                    <label class="block text-xs font-bold mb-2" style="color: var(--text-secondary);">Nama Lengkap Admin</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500"
                           style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);"
                           placeholder="Sesuai pendaftaran" required>
                </div>
                
                <button type="submit" 
                        class="w-full py-3 rounded-xl text-white font-bold transition-all hover:shadow-lg"
                        style="background: linear-gradient(135deg, #f59e0b, #ef4444); border: none;">
                    Verifikasi Data
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm font-semibold no-underline" style="color: var(--text-muted);">← Kembali ke Login Admin</a>
            </div>
        </div>
    </div>
</body>
</html>
