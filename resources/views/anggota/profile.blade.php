@extends('layouts.anggota')

@section('content')
<div class="py-10 px-6">
    <div class="max-w-4xl mx-auto">
        
        @if (session('success'))
        <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border);">
            <p style="color: var(--alert-success-text); font-size: 13px; font-weight: 500;">✅ {{ session('success') }}</p>
        </div>
        @endif
        @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
            <ul class="list-disc list-inside" style="color: var(--alert-error-text); font-size: 13px;">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="p-6 rounded-xl text-center" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                    <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center text-3xl mb-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-1" style="color: var(--text-primary);">{{ $anggota->nama }}</h3>
                    <p class="mb-4 text-sm font-semibold" style="color: var(--tag-indigo-text);">{{ $anggota->kelas }}</p>
                    <div class="space-y-3 text-left">
                        <div class="p-3 rounded-lg" style="background: var(--bg-input);">
                            <p class="text-xs uppercase font-bold" style="color: var(--text-muted);">NIS</p>
                            <p class="font-medium" style="color: var(--text-primary);">{{ $anggota->nis }}</p>
                        </div>
                        <div class="p-3 rounded-lg" style="background: var(--bg-input);">
                            <p class="text-xs uppercase font-bold" style="color: var(--text-muted);">Email</p>
                            <p class="font-medium" style="color: var(--text-primary);">{{ $anggota->email }}</p>
                        </div>
                        <div class="p-3 rounded-lg" style="background: var(--bg-input);">
                            <p class="text-xs uppercase font-bold" style="color: var(--text-muted);">Bergabung Pada</p>
                            <p class="font-medium" style="color: var(--text-primary);">{{ $anggota->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Forms -->
            <div class="lg:col-span-2">
                <div class="p-6 rounded-xl mb-6 relative overflow-hidden" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                    <!-- Ornamen -->
                    <div class="absolute top-0 right-0 w-32 h-32 rounded-full" style="background: radial-gradient(circle, var(--radial-1), transparent); transform: translate(30%, -30%);"></div>

                    <h4 class="text-lg font-bold mb-5 relative z-10" style="color: var(--text-primary);">Edit Profil</h4>
                    <form method="POST" action="{{ route('anggota.profile.update') }}" class="relative z-10">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase tracking-wide" style="color: var(--text-secondary);">NIS</label>
                                <input type="text" value="{{ $anggota->nis }}" class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-indigo-500/50" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-dimmed);" disabled readonly>
                                <p class="text-xs mt-1" style="color: var(--text-dimmed);">NIS tidak dapat diubah</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase tracking-wide" style="color: var(--text-secondary);">Kelas</label>
                                <select name="kelas" class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-indigo-500/50" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                                    @foreach(['X RPL 1','X RPL 2','XI RPL 1','XI RPL 2','XII RPL 1','XII RPL 2','X TKJ 1','XI TKJ 1','XII TKJ 1'] as $kelas)
                                    <option value="{{ $kelas }}" {{ $anggota->kelas == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-bold mb-2 uppercase tracking-wide" style="color: var(--text-secondary);">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama', $anggota->nama) }}" class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-indigo-500/50" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" required>
                        </div>
                        <div class="mb-6">
                            <label class="block text-xs font-bold mb-2 uppercase tracking-wide" style="color: var(--text-secondary);">Email</label>
                            <input type="email" name="email" value="{{ old('email', $anggota->email) }}" class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-indigo-500/50" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" required>
                        </div>
                        <button type="submit" class="w-full py-3 rounded-xl text-white font-bold text-sm transition-all hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">Simpan Perubahan</button>
                    </form>
                </div>
                
                <div class="p-6 rounded-xl relative overflow-hidden" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
                     <!-- Ornamen -->
                     <div class="absolute bottom-0 right-0 w-40 h-40 rounded-full" style="background: radial-gradient(circle, var(--radial-2), transparent); transform: translate(30%, 30%);"></div>

                    <h4 class="text-lg font-bold mb-5 relative z-10" style="color: var(--text-primary);">Ubah Password</h4>
                    <form method="POST" action="{{ route('anggota.profile.password') }}" class="relative z-10">
                        @csrf @method('PUT')
                        <div class="mb-4">
                            <label class="block text-xs font-bold mb-2 uppercase tracking-wide" style="color: var(--text-secondary);">Password Lama</label>
                            <input type="password" name="current_password" class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-purple-500/50" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Masukkan password lama" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase tracking-wide" style="color: var(--text-secondary);">Password Baru</label>
                                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-purple-500/50" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Min. 6 karakter" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-2 uppercase tracking-wide" style="color: var(--text-secondary);">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-purple-500/50" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Ulangi password baru" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-3 rounded-xl text-white font-bold text-sm transition-all hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #7c3aed, #9333ea);">Ganti Password Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
