<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary);">
            {{ __('Edit Transaksi') }}
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
                    
                    <!-- Info Transaksi -->
                    <div class="mb-6 p-4 rounded-lg" style="background: var(--bg-input); border: 1px solid var(--border-main);">
                        <h3 class="font-bold mb-2" style="color: var(--text-primary);">Detail Transaksi</h3>
                        <p class="text-sm" style="color: var(--text-secondary);"><strong>Anggota:</strong> {{ $transaksi->anggota->nama }} ({{ $transaksi->anggota->nis }})</p>
                        <p class="text-sm mt-1" style="color: var(--text-secondary);"><strong>Buku:</strong></p>
                        <ul class="ml-4 mt-1">
                            @foreach($transaksi->detailTransaksi as $detail)
                            <li class="text-sm" style="color: var(--text-secondary);">• {{ $detail->buku->judul }}{{ $detail->jumlah > 1 ? ' (×'.$detail->jumlah.')' : '' }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Tanggal Pinjam -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" 
                                   value="{{ old('tanggal_pinjam', $transaksi->tanggal_pinjam->format('Y-m-d')) }}" 
                                   class="w-full rounded-md shadow-sm @error('tanggal_pinjam') border-red-500 @enderror" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" required>
                            @error('tanggal_pinjam')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Tenggat Pengembalian -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Tenggat Pengembalian</label>
                            <input type="date" name="tanggal_pengembalian" 
                                   value="{{ old('tanggal_pengembalian', $transaksi->tanggal_pengembalian ? $transaksi->tanggal_pengembalian->format('Y-m-d') : '') }}" 
                                   class="w-full rounded-md shadow-sm @error('tanggal_pengembalian') border-red-500 @enderror" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                            @error('tanggal_pengembalian')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Tanggal Kembali -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" 
                                   value="{{ old('tanggal_kembali', $transaksi->tanggal_kembali ? $transaksi->tanggal_kembali->format('Y-m-d') : '') }}" 
                                   class="w-full rounded-md shadow-sm @error('tanggal_kembali') border-red-500 @enderror" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                            <p class="text-sm mt-1" style="color: var(--text-muted);">Kosongkan jika belum dikembalikan</p>
                            @error('tanggal_kembali')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary);">Status</label>
                            <select name="status" id="status-select" class="w-full rounded-md shadow-sm @error('status') border-red-500 @enderror" style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" required>
                                <option value="menunggu" {{ old('status', $transaksi->status) == 'menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="dipinjam" {{ old('status', $transaksi->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="dikembalikan" {{ old('status', $transaksi->status) == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="ditolak" {{ old('status', $transaksi->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('transaksi.index') }}" class="font-bold py-2 px-4 rounded" style="background: var(--btn-ghost-bg); color: var(--btn-ghost-text); border: 1px solid var(--btn-ghost-border);">
                                Batal
                            </a>
                            <button type="submit" class="font-bold py-2 px-4 rounded text-white" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

