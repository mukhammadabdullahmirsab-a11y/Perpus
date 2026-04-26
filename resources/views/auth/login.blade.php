<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Perpustakaan</title>
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
    
    <div class="w-full max-w-md mx-auto px-4 relative" style="z-index: 10;">
        
        <!-- Theme Toggle (top-right) -->
        <div class="flex justify-end mb-4">
            @include('layouts.theme-toggle')
        </div>
        
        <div class="p-8 rounded-2xl" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.331 0 4.467.89 6.064 2.346m0-14.304a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.346m0-14.304v14.304" /></svg>
                </div>
                <h2 class="text-2xl font-black" style="color: var(--text-primary);">LOGIN</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Login ke akun Anda</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
                <ul class="list-disc list-inside" style="color: var(--alert-error-text); font-size: 13px;">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
            @endif

            @if (session('status'))
            <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border);">
                <p style="color: var(--alert-success-text); font-size: 13px;">{{ session('status') }}</p>
            </div>
            @endif
            
            <!-- Single Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-xs font-bold mb-2" style="color: var(--text-secondary);">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;" placeholder="email@example.com" required autofocus>
                </div>

                <div class="mb-5">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold" style="color: var(--text-secondary);">Password</label>
                        <a href="{{ route('anggota.password.request') }}" class="text-xs font-semibold no-underline hover:opacity-80" style="color: #6366f1;">Lupa sandi?</a>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" 
                               class="w-full px-4 py-3 rounded-xl pr-12 transition-all focus:ring-2 focus:ring-indigo-500" 
                               style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;" 
                               placeholder="Masukkan password..." required>
                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 transition-colors group" title="Tampilkan/Sembunyikan Password">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 transition-colors" style="color: var(--text-primary);">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 transition-colors hidden" style="color: var(--text-primary);">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.822 7.822L21 21m-2.278-2.278L15.07 15.07M9.172 9.172L7.336 7.336M15.07 15.07a3 3 0 11-4.243-4.243L15.07 15.07z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded" style="background: var(--bg-input); border: 1.5px solid var(--border-input);">
                        <span class="text-sm" style="color: var(--text-muted);">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl text-white font-bold transition-all hover:shadow-lg" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
                    Masuk
                </button>
            </form>

            <div class="text-center mt-6">
                <p style="color: var(--text-muted); font-size: 14px;">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold no-underline" style="color: var(--nav-active-text);">Daftar disini</a></p>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');
        const eyeOffIcon = document.querySelector('#eyeOffIcon');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // toggle icons
            eyeIcon.classList.toggle('hidden');
            eyeOffIcon.classList.toggle('hidden');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
