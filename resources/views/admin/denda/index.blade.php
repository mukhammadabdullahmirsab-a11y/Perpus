<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl" style="color: var(--text-primary);">
            Rekapan Denda Peminjaman
        </h2>
    </x-slot>
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="p-5 rounded-xl card-hover" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Total Denda Keterlambatan</p>
            <h3 class="text-2xl font-black text-yellow-500">Rp {{ number_format($totalDendaKeterlambatan, 0, ',', '.') }}</h3>
        </div>
        <div class="p-5 rounded-xl card-hover" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Total Denda Kerusakan</p>
            <h3 class="text-2xl font-black text-red-500">Rp {{ number_format($totalDendaKerusakan, 0, ',', '.') }}</h3>
        </div>
        <div class="p-5 rounded-xl card-hover" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
            <p class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Total Keseluruhan</p>
            <h3 class="text-2xl font-black" style="color: var(--tag-green-text);">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="rounded-xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-main); box-shadow: var(--shadow-sm);">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead style="background: var(--bg-table-head);">
                    <tr>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Anggota</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Buku</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Tgl Pinjam/Kembali</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Denda Terlambat</th>
                        <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Denda Rusak/Hilang</th>
                        <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-main)]">
                    @forelse($details as $detail)
                    <tr class="hover:bg-[var(--bg-hover)]">
                        <td class="px-6 py-4">
                            <p class="font-bold text-sm" style="color: var(--text-primary);">{{ $detail->transaksi->anggota->nama }}</p>
                            <p class="text-xs" style="color: var(--text-muted);">{{ $detail->transaksi->anggota->nis }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm" style="color: var(--text-primary);">{{ mb_strimwidth($detail->buku->judul, 0, 30, '...') }}</p>
                            <p class="text-xs" style="color: var(--text-muted);">Kondisi kembali: {{ ucfirst($detail->kondisi_buku ?? 'Baik') }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <p class="text-xs gap-1" style="color: var(--text-secondary);"><span class="font-semibold">Keluar:</span> {{ $detail->transaksi->tanggal_pinjam->format('d/m/Y') }}</p>
                            <p class="text-xs mt-1 gap-1" style="color: var(--text-secondary);"><span class="font-semibold">Masuk:</span> {{ $detail->tanggal_kembali->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-yellow-600 font-medium">
                            @if($detail->denda_keterlambatan > 0)
                                Rp {{ number_format($detail->denda_keterlambatan, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm text-red-600 font-bold">
                            @if($detail->denda_kerusakan > 0)
                                Rp {{ number_format($detail->denda_kerusakan, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($detail->status_denda === 'lunas')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full" style="background: var(--tag-green-bg); color: var(--tag-green-text);">Lunas</span>
                            @else
                                <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg mb-2 inline-block" style="background: var(--tag-red-bg); color: var(--tag-red-text);">Belum Lunas</span>
                                <form action="{{ route('admin.denda.lunasi', $detail->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition font-medium w-full shadow-sm">Konfirmasi</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center" style="color: var(--text-dimmed);">
                            Belum ada riwayat pembayaran denda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($details->hasPages())
        <div class="px-6 py-4 border-t" style="border-color: var(--border-main);">
            {{ $details->links() }}
        </div>
        @endif
    </div>
</div>
</x-app-layout>
