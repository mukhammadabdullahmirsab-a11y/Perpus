<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl" style="color: var(--text-primary);">
            {{ __('Laporan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter Card -->
            <div class="rounded-2xl p-8 mb-8" style="background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border-main);">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.75 12H5.25" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold" style="color: var(--text-primary);">Cetak Laporan</h3>
                        <p class="text-sm" style="color: var(--text-muted);">Pilih periode dan filter untuk mencetak laporan peminjaman</p>
                    </div>
                </div>
                
                <form action="{{ route('laporan.cetak') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--text-secondary);">Rentang Waktu</label>
                            <select name="filter_otomatis" id="filter_otomatis" class="w-full px-4 py-3 rounded-xl"
                                    style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);" onchange="toggleCustomDate()">
                                <option value="1_bulan">1 Bulan Terakhir</option>
                                <option value="1_minggu">1 Minggu Terakhir</option>
                                <option value="1_hari">Hari Ini</option>
                                <option value="custom">Pilih Tanggal Sendiri</option>
                            </select>
                        </div>
                        <div id="wrap_dari_tanggal" style="display: none;">
                            <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--text-secondary);">Dari Tanggal</label>
                            <input type="date" name="dari_tanggal" id="dari_tanggal" required
                                   class="w-full px-4 py-3 rounded-xl disabled:opacity-50"
                                   style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;"
                                   value="{{ old('dari_tanggal', now()->format('Y-m-d')) }}">
                        </div>
                        <div id="wrap_sampai_tanggal" style="display: none;">
                            <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--text-secondary);">Sampai Tanggal</label>
                            <input type="date" name="sampai_tanggal" id="sampai_tanggal" required
                                   class="w-full px-4 py-3 rounded-xl disabled:opacity-50"
                                   style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary); outline: none;"
                                   value="{{ old('sampai_tanggal', now()->format('Y-m-d')) }}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--text-secondary);">Status Transaksi</label>
                            <select name="status" class="w-full px-4 py-3 rounded-xl"
                                    style="background: var(--bg-input); border: 1.5px solid var(--border-input); color: var(--text-primary);">
                                <option value="">Semua Status</option>
                                <option value="dipinjam">Dipinjam</option>
                                <option value="dikembalikan">Dikembalikan</option>
                            </select>
                        </div>
                    </div>
                    
                    @if ($errors->any())
                    <div class="mb-4 p-4 rounded-xl" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border);">
                        @foreach ($errors->all() as $error)
                        <p style="color: var(--alert-error-text); font-size: 13px;">❌ {{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                    
                    <button type="submit" class="px-8 py-3 rounded-xl text-white font-bold text-sm transition-all hover:shadow-lg hover:-translate-y-0.5" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        🖨️ Cetak Laporan
                    </button>
                </form>
            </div>

            <!-- Info -->
            <div class="p-4 rounded-xl" style="background: var(--tag-indigo-bg); border: 1px solid rgba(99, 102, 241, 0.2);">
                <p class="text-xs font-medium" style="color: var(--tag-indigo-text);">
                    ℹ️ Laporan akan ditampilkan sebagai preview terlebih dahulu. Anda dapat melihat isinya sebelum men-download file PDF.
                </p>
            </div>
        </div>
    </div>
    <script>
        function toggleCustomDate() {
            const filter = document.getElementById('filter_otomatis').value;
            const wrapDari = document.getElementById('wrap_dari_tanggal');
            const wrapSampai = document.getElementById('wrap_sampai_tanggal');
            const inputDari = document.getElementById('dari_tanggal');
            const inputSampai = document.getElementById('sampai_tanggal');

            if (filter === 'custom') {
                wrapDari.style.display = 'block';
                wrapSampai.style.display = 'block';
                inputDari.removeAttribute('disabled');
                inputSampai.removeAttribute('disabled');
            } else {
                wrapDari.style.display = 'none';
                wrapSampai.style.display = 'none';
                inputDari.setAttribute('disabled', 'true');
                inputSampai.setAttribute('disabled', 'true');
            }
        }
        
        // Panggil saat page load
        document.addEventListener('DOMContentLoaded', toggleCustomDate);
    </script>
</x-app-layout>
