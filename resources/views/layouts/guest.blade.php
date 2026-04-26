<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="font-outfit antialiased selection:bg-indigo-600 selection:text-white">
        <div class="min-h-screen relative flex flex-col justify-center items-center py-12 bg-slate-50 overflow-hidden">
            <!-- Background Orbs -->
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-200 rounded-full blur-[120px] opacity-50"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-200 rounded-full blur-[120px] opacity-50"></div>
            
            <div class="relative z-10 w-full px-4">
                <div class="w-full sm:max-w-md mx-auto">
                    <div class="text-center mb-10">
                        <a href="/" class="inline-block p-4 bg-white rounded-[2rem] shadow-xl shadow-indigo-100 mb-6">
                            <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </a>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Perpus Digital</h1>
                        <p class="text-slate-500 mt-2 font-medium">Sistem Manajemen Perpustakaan Terpadu</p>
                    </div>

                    <div class="bg-white/80 backdrop-blur-xl border border-white p-10 shadow-2xl shadow-indigo-100 rounded-[3rem]">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
