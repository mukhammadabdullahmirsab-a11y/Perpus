<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary);">
            {{ __('Tambah Peminjaman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('error'))
            <div class="mb-4 px-4 py-3 rounded" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border); color: var(--alert-error-text);">
                {{ session('error') }}
            </div>
            @endif
            
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                <div class="p-6">
                    <form action="{{ route('transaksi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="dipinjam">
                        
                        <!-- Anggota -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Anggota</label>
                            <select name="anggota_id" class="w-full rounded-md shadow-sm @error('anggota_id') border-red-500 @enderror" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                    {{ $anggota->nis }} - {{ $anggota->nama }} ({{ $anggota->kelas }})
                                </option>
                                @endforeach
                            </select>
                            @error('anggota_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Daftar Buku -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Buku yang Dipinjam</label>
                            <div id="buku-list" class="space-y-3">
                                <div class="buku-row flex gap-3 items-start">
                                    <div class="flex-1">
                                        <select name="buku_id[]" class="w-full rounded-md shadow-sm" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" required>
                                            <option value="">-- Pilih Buku --</option>
                                            @foreach($bukus as $buku)
                                            <option value="{{ $buku->id }}">
                                                {{ $buku->judul }} - {{ $buku->penulis }} (Stok: {{ $buku->stok }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-24">
                                        <input type="number" name="jumlah[]" value="1" min="1" class="w-full rounded-md shadow-sm text-center" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" placeholder="Jml" required>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="btn-tambah-buku" class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all hover:opacity-80"
                                    style="background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px dashed rgba(99, 102, 241, 0.4);">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                Tambah Buku Lain
                            </button>
                            @error('buku_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Tanggal Pinjam -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" 
                                   class="w-full rounded-md shadow-sm @error('tanggal_pinjam') border-red-500 @enderror" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" required>
                            @error('tanggal_pinjam')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Tanggal Pengembalian (Tenggat) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Tenggat Pengembalian</label>
                            <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" 
                                   value="{{ old('tanggal_pengembalian', date('Y-m-d', strtotime('+7 days'))) }}" 
                                   class="w-full rounded-md shadow-sm @error('tanggal_pengembalian') border-red-500 @enderror" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                            <p class="text-sm mt-1" style="color: var(--text-muted);">Default: 7 hari dari tanggal pinjam</p>
                            @error('tanggal_pengembalian')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('transaksi.index') }}" class="font-bold py-2 px-4 rounded" style="background: var(--btn-ghost-bg); color: var(--btn-ghost-text); border: 1px solid var(--btn-ghost-border);">
                                Batal
                            </a>
                            <button type="submit" class="font-bold py-2 px-4 rounded text-white" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
                                Simpan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-set tanggal_pengembalian when tanggal_pinjam changes
        document.getElementById('tanggal_pinjam').addEventListener('change', function() {
            const pinjamDate = new Date(this.value);
            pinjamDate.setDate(pinjamDate.getDate() + 7);
            const pengembalian = pinjamDate.toISOString().split('T')[0];
            document.getElementById('tanggal_pengembalian').value = pengembalian;
        });

        // Dynamic add/remove book rows
        document.getElementById('btn-tambah-buku').addEventListener('click', function() {
            const list = document.getElementById('buku-list');
            const firstRow = list.querySelector('.buku-row');
            const newRow = firstRow.cloneNode(true);
            
            // Reset values
            newRow.querySelector('select').value = '';
            newRow.querySelector('input[type="number"]').value = '1';

            // Add remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'w-8 h-8 rounded-lg flex items-center justify-center shrink-0 mt-1 transition-all hover:opacity-80';
            removeBtn.style.cssText = 'background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.3);';
            removeBtn.innerHTML = '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>';
            removeBtn.addEventListener('click', function() {
                newRow.remove();
            });
            
            newRow.appendChild(removeBtn);
            list.appendChild(newRow);
        });
    </script>
</x-app-layout>
