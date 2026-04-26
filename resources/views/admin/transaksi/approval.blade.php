<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary);">
                {{ __('Form Approval & Pengembalian') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Messages -->
            @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded" style="background: var(--alert-success-bg); border: 1px solid var(--alert-success-border); color: var(--alert-success-text);">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="mb-4 px-4 py-3 rounded" style="background: var(--alert-error-bg); border: 1px solid var(--alert-error-border); color: var(--alert-error-text);">
                {{ session('error') }}
            </div>
            @endif
            

            <!-- Table -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: var(--bg-card); border: 1px solid var(--border-main);">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full">
                        <thead style="background: var(--bg-table-head);">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-muted);">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-muted);">Anggota</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-muted);">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-muted);">Tgl Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-muted);">Tenggat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-muted);">Tgl Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-muted);">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-muted);">Denda</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-muted);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="border-top: 1px solid var(--border-main);">
                            @forelse ($transaksis as $index => $transaksi)
                            <tr style="border-bottom: 1px solid var(--border-main);">
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-muted);">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium" style="color: var(--text-primary);">{{ $transaksi->anggota->nama }}</div>
                                    <div class="text-sm" style="color: var(--text-muted);">{{ $transaksi->anggota->nis }} - {{ $transaksi->anggota->kelas }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($transaksi->detailTransaksi as $i => $detail)
                                        <div class="{{ $i > 0 ? 'mt-1' : '' }}">
                                            <div class="text-sm font-medium" style="color: var(--text-primary);">{{ $detail->buku->judul }}{{ $detail->jumlah > 1 ? ' (×'.$detail->jumlah.')' : '' }}</div>
                                            <div class="text-sm" style="color: var(--text-muted);">{{ $detail->buku->penulis }}</div>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-secondary);">
                                    {{ $transaksi->tanggal_pinjam->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @foreach($transaksi->detailTransaksi as $i => $detail)
                                        <div class="{{ $i > 0 ? 'mt-1' : '' }}">
                                            @if($detail->tanggal_pengembalian)
                                                @if($detail->status == 'dipinjam' && now()->gt($detail->tanggal_pengembalian))
                                                    <span class="font-semibold text-xs" style="color: var(--tag-red-text);">{{ $detail->tanggal_pengembalian->format('d/m/Y') }} ⚠️</span>
                                                @else
                                                    <span class="text-xs" style="color: var(--text-secondary);">{{ $detail->tanggal_pengembalian->format('d/m/Y') }}</span>
                                                @endif
                                            @else
                                                <span style="color: var(--text-dimmed);">-</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-secondary);">
                                    {{ $transaksi->tanggal_kembali ? $transaksi->tanggal_kembali->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaksi->status == 'menunggu')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="background: var(--tag-blue-bg); color: var(--tag-blue-text); border: 1px solid var(--tag-blue-border);">
                                        Menunggu
                                    </span>
                                    @elseif($transaksi->status == 'dipinjam')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="background: var(--tag-yellow-bg); color: var(--tag-yellow-text); border: 1px solid var(--tag-yellow-border);">
                                        Dipinjam
                                    </span>
                                    @elseif($transaksi->status == 'dikembalikan')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="background: var(--tag-green-bg); color: var(--tag-green-text); border: 1px solid var(--tag-green-border);">
                                        Dikembalikan
                                    </span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="background: var(--tag-red-bg); color: var(--tag-red-text); border: 1px solid var(--tag-red-border);">
                                        Ditolak
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($transaksi->denda > 0)
                                    <span style="color: var(--tag-red-text);">Rp{{ number_format($transaksi->denda, 0, ',', '.') }}</span>
                                    @elseif($transaksi->status == 'dipinjam' && $transaksi->isTerlambat())
                                    <span style="color: var(--tag-yellow-text);">~Rp{{ number_format($transaksi->hitungDenda(), 0, ',', '.') }}</span>
                                    @else
                                    <span style="color: var(--tag-green-text);">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex flex-col gap-2 min-w-max">
                                        @if($transaksi->status == 'menunggu')
                                            <div class="flex gap-2">
                                                <form action="{{ route('transaksi.approve', $transaksi->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none" onclick="return confirm('Setujui peminjaman ini? Stok buku akan berkurang.')">
                                                        ✅ Terima
                                                    </button>
                                                </form>
                                                <form action="{{ route('transaksi.reject', $transaksi->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none" onclick="return confirm('Tolak peminjaman ini?')">
                                                        ❌ Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($transaksi->status == 'dipinjam')
                                            @foreach($transaksi->detailTransaksi as $i => $detail)
                                                <div class="{{ $i > 0 ? 'mt-1' : '' }}">
                                                    @if($detail->status == 'dipinjam')
                                                    <form action="{{ route('transaksi.kembalikan_detail', $detail->id) }}" method="POST" class="inline" id="form-kembali-{{ $detail->id }}">
                                                        @csrf
                                                        <input type="hidden" name="kondisi_buku" id="kondisi-{{ $detail->id }}" value="baik">
                                                        <input type="hidden" name="denda_kerusakan" id="denda-{{ $detail->id }}" value="0">
                                                        <button type="button" class="px-2 py-1 text-[10px] bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none" onclick="promptKembalikan({{ $detail->id }})">
                                                            Pilih Kondisi: {{ Str::limit($detail->buku->judul, 15) }}
                                                        </button>
                                                    </form>
                                                    @else
                                                        <span class="px-2 py-1 text-[10px] rounded" style="background: var(--tag-green-bg); color: var(--tag-green-text); border: 1px solid var(--tag-green-bg);">✅ Dikembalikan</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center" style="color: var(--text-muted);">
                                    Tidak ada data transaksi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function promptKembalikan(id) {
        Swal.fire({
            title: 'Konfirmasi Pengembalian',
            html: `
                <div class="mb-4 text-left">
                    <label class="block text-sm font-medium mb-1">Kondisi Buku Saat Dikembalikan</label>
                    <select id="swal-kondisi" class="w-full rounded-lg shadow-sm focus:ring-indigo-500" style="background: #f8fafc; border: 1px solid #cbd5e1; color: #0f172a; padding: 8px;">
                        <option value="baik">Baik</option>
                        <option value="rusak">Rusak</option>
                        <option value="hilang">Hilang</option>
                    </select>
                </div>
                <div class="mb-2 text-left" id="denda-container" style="display: none;">
                    <label class="block text-sm font-medium mb-1">Nominal Denda Kerusakan/Kehilangan (Rp)</label>
                    <input type="number" id="swal-denda" class="w-full rounded-lg shadow-sm focus:ring-indigo-500" value="0" min="0" style="background: #f8fafc; border: 1px solid #cbd5e1; color: #0f172a; padding: 8px;">
                    <p class="text-[10px] mt-1" style="color: #64748b;">Isi 0 jika tidak ada denda tambahan.</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kembalikan',
            cancelButtonText: 'Batal',
            didOpen: () => {
                const kondisiSelect = document.getElementById('swal-kondisi');
                const dendaContainer = document.getElementById('denda-container');
                
                kondisiSelect.addEventListener('change', (e) => {
                    if (e.target.value === 'baik') {
                        dendaContainer.style.display = 'none';
                        document.getElementById('swal-denda').value = '0';
                    } else {
                        dendaContainer.style.display = 'block';
                    }
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const kondisi = document.getElementById('swal-kondisi').value;
                const denda = document.getElementById('swal-denda').value;
                
                document.getElementById('kondisi-' + id).value = kondisi;
                document.getElementById('denda-' + id).value = denda || 0;
                document.getElementById('form-kembali-' + id).submit();
            }
        });
    }
</script>
