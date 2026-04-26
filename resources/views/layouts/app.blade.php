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
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Theme System -->
        @include('layouts.theme')
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="antialiased" style="background: var(--bg-main);">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-y-auto w-full transition-all duration-300" id="main-content">
                <!-- Top Header (For Mobile Toggle & Right Elements) -->
                <header class="sticky top-0 z-20 px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between transition-all" style="background: var(--bg-nav); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border-main);">
                    <!-- Mobile Hamburger -->
                    <div class="flex items-center gap-4 sm:hidden">
                        <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); document.getElementById('main-content').classList.toggle('sm:ml-64')" class="p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" style="color: var(--text-muted); hover:background: var(--bg-hover);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>

                    <!-- Page Default Title -->
                    <div class="hidden sm:block">
                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>

                    <!-- Right Side Elements -->
                    <div class="flex items-center gap-3 ms-auto">
                        @include('layouts.theme-toggle')
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                            <div class="w-6 h-6 rounded flex items-center justify-center text-xs font-bold text-white" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium hidden sm:inline-block" style="color: var(--text-secondary);">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </header>

                <!-- Page Heading (Mobile) -->
                @isset($header)
                    <header class="sm:hidden px-4 py-4" style="background: var(--bg-header); border-bottom: 1px solid var(--border-main);">
                        {{ $header }}
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
