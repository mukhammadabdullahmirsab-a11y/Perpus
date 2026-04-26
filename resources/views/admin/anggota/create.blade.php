<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary);">
            {{ __('Tambah Anggota Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                <div class="p-6">
                    <form action="{{ route('kelola-anggota.store') }}" method="POST">
                        @csrf
                        
                        <!-- NIS -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">NIS</label>
                            <input type="text" name="nis" value="{{ old('nis') }}" 
                                   class="w-full rounded-md shadow-sm @error('nis') border-red-500 @enderror"
                                   style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);"
                                   placeholder="Masukkan NIS" required>
                            @error('nis')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" 
                                   class="w-full rounded-md shadow-sm @error('nama') border-red-500 @enderror"
                                   style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);"
                                   placeholder="Masukkan nama lengkap" required>
                            @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Kelas -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Kelas</label>
                            <select name="kelas" class="w-full rounded-md shadow-sm @error('kelas') border-red-500 @enderror" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="X RPL 1" {{ old('kelas') == 'X RPL 1' ? 'selected' : '' }}>X RPL 1</option>
                                <option value="X RPL 2" {{ old('kelas') == 'X RPL 2' ? 'selected' : '' }}>X RPL 2</option>
                                <option value="XI RPL 1" {{ old('kelas') == 'XI RPL 1' ? 'selected' : '' }}>XI RPL 1</option>
                                <option value="XI RPL 2" {{ old('kelas') == 'XI RPL 2' ? 'selected' : '' }}>XI RPL 2</option>
                                <option value="XII RPL 1" {{ old('kelas') == 'XII RPL 1' ? 'selected' : '' }}>XII RPL 1</option>
                                <option value="XII RPL 2" {{ old('kelas') == 'XII RPL 2' ? 'selected' : '' }}>XII RPL 2</option>
                                <option value="X TKJ 1" {{ old('kelas') == 'X TKJ 1' ? 'selected' : '' }}>X TKJ 1</option>
                                <option value="XI TKJ 1" {{ old('kelas') == 'XI TKJ 1' ? 'selected' : '' }}>XI TKJ 1</option>
                                <option value="XII TKJ 1" {{ old('kelas') == 'XII TKJ 1' ? 'selected' : '' }}>XII TKJ 1</option>
                            </select>
                            @error('kelas')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="w-full rounded-md shadow-sm @error('email') border-red-500 @enderror"
                                   style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);"
                                   placeholder="Masukkan email" required>
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Password</label>
                            <input type="password" name="password" 
                                   class="w-full rounded-md shadow-sm @error('password') border-red-500 @enderror"
                                   style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);"
                                   placeholder="Masukkan password (min. 6 karakter)" required>
                            @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('kelola-anggota.index') }}" class="font-bold py-2 px-4 rounded" style="background: var(--btn-ghost-bg); color: var(--btn-ghost-text); border: 1px solid var(--btn-ghost-border);">
                                Batal
                            </a>
                            <button type="submit" class="font-bold py-2 px-4 rounded text-white" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
                                Simpan Anggota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
