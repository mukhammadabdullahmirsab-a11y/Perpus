<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Anggota;
use Barryvdh\DomPDF\Facade\Pdf;

class AnggotaAuthController extends Controller
{
    /**
     * Show the login form for anggota
     */
    public function showLoginForm()
    {
        return view('anggota.login');
    }


    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('anggota')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('anggota.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::guard('anggota')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Show anggota dashboard
     */
    public function dashboard()
    {
        $anggota = Auth::guard('anggota')->user();
        
        // Count borrowed and returned books
        $bukuDipinjam = \App\Models\Transaksi::where('anggota_id', $anggota->id)
            ->where('status', 'dipinjam')
            ->count();
        $bukuDikembalikan = \App\Models\Transaksi::where('anggota_id', $anggota->id)
            ->where('status', 'dikembalikan')
            ->count();
        
        // Unpaid fines
        $unpaidFines = \App\Models\DetailTransaksi::with('buku', 'transaksi')
            ->whereHas('transaksi', function($q) use($anggota) {
                $q->where('anggota_id', $anggota->id);
            })
            ->where('status_denda', 'belum_lunas')
            ->get();
            
        return view('anggota.dashboard', compact('anggota', 'bukuDipinjam', 'bukuDikembalikan', 'unpaidFines'));
    }

    /**
     * Show Forgot Password Form
     */
    public function showForgotPasswordForm()
    {
        return view('anggota.forgot-password');
    }

    /**
     * Verify data for Forgot Password
     */
    public function verifyForgotPassword(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string',
            'email' => 'required|email',
            'nama' => 'required|string',
        ]);

        $anggota = \App\Models\Anggota::where('nis', $validated['nis'])
            ->where('email', $validated['email'])
            ->where('nama', $validated['nama'])
            ->first();

        if ($anggota) {
            // Data cocok, simpan id di session
            session(['reset_anggota_id' => $anggota->id]);
            return redirect()->route('anggota.password.reset');
        }

        return back()->withErrors(['message' => 'Data tidak ditemukan atau tidak cocok. Pastikan penulisan NIS, Email, dan Nama persis dengan data akun.'])->withInput();
    }

    /**
     * Show Reset Password Form
     */
    public function showResetPasswordForm()
    {
        if (!session('reset_anggota_id')) {
            return redirect()->route('anggota.login')->withErrors(['message' => 'Silakan verifikasi data terlebih dahulu.']);
        }
        return view('anggota.reset-password');
    }

    /**
     * Handle Reset Password
     */
    public function resetPassword(Request $request)
    {
        if (!session('reset_anggota_id')) {
            return redirect()->route('anggota.login')->withErrors(['message' => 'Sesi verifikasi telah berakhir. Silakan ulangi.']);
        }

        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Password baru harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        $anggota = \App\Models\Anggota::find(session('reset_anggota_id'));
        if ($anggota) {
            $anggota->update([
                'password' => Hash::make($validated['password']),
            ]);
            
            // Hapus session
            session()->forget('reset_anggota_id');
            
            return redirect()->route('anggota.login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
        }

        return redirect()->route('anggota.login')->withErrors(['message' => 'Gagal mengubah password. Pengguna tidak ditemukan.']);
    }

    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        return view('anggota.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:anggotas,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'email' => 'required|email|unique:anggotas,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nis.unique' => 'NIS sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $anggota = Anggota::create([
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'kelas' => $validated['kelas'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        $anggota = Auth::guard('anggota')->user();
        return view('anggota.profile', compact('anggota'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'email' => 'required|email|unique:anggotas,email,' . $anggota->id,
        ], [
            'email.unique' => 'Email sudah digunakan oleh anggota lain.',
        ]);

        $anggota->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if (!Hash::check($validated['current_password'], $anggota->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $anggota->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Show book catalog
     */
    public function katalog(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();
        
        $query = \App\Models\Buku::with(['kategori.rak']);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }
        
        $bukus = $query->orderBy('judul', 'asc')->get();
        
        // Grouping: Rak -> Kategori -> Buku
        $groupedByRak = $bukus->groupBy(function($item) {
            if ($item->kategori && $item->kategori->rak) {
                return $item->kategori->rak->nama_rak;
            }
            return 'Rak Lainnya';
        })->sortKeys()->map(function($bukusByRak) {
            return $bukusByRak->groupBy(function($item) {
                return $item->kategori ? $item->kategori->nama_kategori : 'Lainnya';
            })->sortKeys();
        });

        $kategoris = \App\Models\Kategori::orderBy('nama_kategori', 'asc')->get();
        
        return view('anggota.katalog', compact('anggota', 'groupedByRak', 'kategoris', 'bukus'));
    }

    /**
     * Detail buku
     */
    public function detailBuku($buku_id)
    {
        $anggota = Auth::guard('anggota')->user();
        $buku = \App\Models\Buku::with(['kategori.rak'])->findOrFail($buku_id);
        
        return view('anggota.detail-buku', compact('anggota', 'buku'));
    }

    /**
     * Tambah buku ke keranjang (session)
     */
    public function tambahKeranjang(Request $request, $buku_id)
    {
        $buku = \App\Models\Buku::findOrFail($buku_id);
        
        $jumlahBuku = (int) $request->input('jumlah', 1);

        if ($buku->stok < $jumlahBuku) {
            return back()->with('error', 'Maaf, stok buku tidak mencukupi.');
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$buku_id])) {
            if ($keranjang[$buku_id]['jumlah'] + $jumlahBuku > $buku->stok) {
                return back()->with('error', 'Stok buku ini tidak mencukupi untuk ditambah lagi sejumlah ' . $jumlahBuku . '.');
            }
            $keranjang[$buku_id]['jumlah'] += $jumlahBuku;
        } else {
            $keranjang[$buku_id] = [
                'buku_id' => $buku_id,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'jumlah' => $jumlahBuku,
            ];
        }

        session()->put('keranjang', $keranjang);

        return redirect()->route('anggota.keranjang')->with('success', "Buku \"{$buku->judul}\" ({$jumlahBuku} buah) ditambahkan ke keranjang! ({$this->jumlahKeranjang()} tipe buku di keranjang)");
    }

    /**
     * Hapus buku dari keranjang
     */
    public function hapusKeranjang($index)
    {
        $keranjang = session()->get('keranjang', []);
        if (isset($keranjang[$index])) {
            unset($keranjang[$index]);
        }
        session()->put('keranjang', $keranjang);

        return back()->with('success', 'Buku dihapus dari keranjang.');
    }

    /**
     * Tampilkan halaman keranjang
     */
    public function keranjang()
    {
        $anggota = Auth::guard('anggota')->user();
        $keranjangOrig = session()->get('keranjang', []);
        
        // Normalize keranjang keys and grouping for older sessions
        $keranjang = [];
        $needsUpdate = false;
        
        foreach ($keranjangOrig as $key => $item) {
            $bId = $item['buku_id'];
            if (!isset($keranjang[$bId])) {
                $keranjang[$bId] = $item;
                if ((string)$key !== (string)$bId) {
                    $needsUpdate = true;
                }
            } else {
                $keranjang[$bId]['jumlah'] += $item['jumlah'];
                $needsUpdate = true;
            }
        }
        
        if ($needsUpdate || count($keranjangOrig) !== count($keranjang)) {
            session()->put('keranjang', $keranjang);
        }
        
        // Load book data fresh from DB
        $bukuIds = collect($keranjang)->pluck('buku_id')->unique()->toArray();
        $bukus = \App\Models\Buku::whereIn('id', $bukuIds)->get()->keyBy('id');

        return view('anggota.keranjang', compact('anggota', 'keranjang', 'bukus'));
    }

    /**
     * Checkout keranjang — buat satu transaksi dengan semua buku
     */
    public function checkoutKeranjang(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        
        if (empty($keranjang)) {
            return redirect()->route('anggota.katalog')->with('error', 'Keranjang kosong.');
        }

        $validated = $request->validate([
            'tanggal_pengembalian' => 'required|array',
            'tanggal_pengembalian.*' => 'required|date|after_or_equal:tomorrow',
        ], [
            'tanggal_pengembalian.*.after_or_equal' => 'Tanggal pengembalian minimal adalah hari esok.',
        ]);

        $anggota = Auth::guard('anggota')->user();

        // Verify stock for all books
        // Need to group by book_id to check total requested stock
        $requestedQuantities = [];
        foreach ($keranjang as $index => $item) {
            $bId = $item['buku_id'];
            if (!isset($requestedQuantities[$bId])) {
                $requestedQuantities[$bId] = 0;
            }
            $requestedQuantities[$bId] += $item['jumlah'];
        }

        foreach ($requestedQuantities as $buku_id => $totalRequested) {
            $buku = \App\Models\Buku::find($buku_id);
            if (!$buku || $buku->stok < $totalRequested) {
                return back()->with('error', "Stok buku \"{$buku->judul}\" tidak mencukupi untuk jumlah yang diminta.");
            }
        }

        // Create single transaction
        $transaksi = \App\Models\Transaksi::create([
            'anggota_id' => $anggota->id,
            'tanggal_pinjam' => now(),
            // Fallback for global field
            'tanggal_pengembalian' => reset($validated['tanggal_pengembalian']),
            'tanggal_kembali' => null,
            'status' => 'menunggu',
        ]);

        // Create detail for each book
        foreach ($keranjang as $index => $item) {
            \App\Models\DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'buku_id' => $item['buku_id'],
                'jumlah' => $item['jumlah'],
                'tanggal_pengembalian' => $validated['tanggal_pengembalian'][$index],
                'status' => 'dipinjam',
            ]);
        }

        // Clear cart
        session()->forget('keranjang');

        return redirect()->route('anggota.riwayat')->with('success', 'Pengajuan peminjaman ' . count($keranjang) . ' buku berhasil! Menunggu konfirmasi dari petugas.');
    }

    /**
     * Helper: jumlah item di keranjang
     */
    private function jumlahKeranjang(): int
    {
        return count(session()->get('keranjang', []));
    }

    /**
     * Pinjam buku
     */
    public function pinjamBuku(Request $request, $buku_id)
    {
        $anggota = Auth::guard('anggota')->user();
        $buku = \App\Models\Buku::findOrFail($buku_id);

        $validated = $request->validate([
            'tanggal_pengembalian' => 'required|date|after_or_equal:tomorrow',
        ], [
            'tanggal_pengembalian.after_or_equal' => 'Tanggal pengembalian minimal adalah hari esok.',
        ]);
        
        // Check stok
        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku habis.');
        }
        
        // Create transaksi
        $transaksi = \App\Models\Transaksi::create([
            'anggota_id' => $anggota->id,
            'tanggal_pinjam' => now(),
            'tanggal_pengembalian' => $validated['tanggal_pengembalian'], // fallback
            'tanggal_kembali' => null,
            'status' => 'menunggu',
        ]);

        // Create detail transaksi
        \App\Models\DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'buku_id' => $buku_id,
            'jumlah' => 1,
            'tanggal_pengembalian' => $validated['tanggal_pengembalian'],
            'status' => 'dipinjam',
        ]);
        
        return redirect()->route('anggota.riwayat')->with('success', 'Pengajuan peminjaman berhasil! Menunggu konfirmasi dari petugas.');
    }

    /**
     * Riwayat peminjaman
     */
    public function riwayatPinjam()
    {
        $anggota = Auth::guard('anggota')->user();
        $transaksis = \App\Models\Transaksi::with('detailTransaksi.buku.kategori.rak')
            ->where('anggota_id', $anggota->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('anggota.riwayat', compact('anggota', 'transaksis'));
    }

    /**
     * Kembalikan buku
     */
    public function kembalikanDetail($detail_id)
    {
        $anggota = Auth::guard('anggota')->user();
        
        $detail = \App\Models\DetailTransaksi::with(['transaksi', 'buku'])
            ->where('id', $detail_id)
            ->where('status', 'dipinjam')
            ->whereHas('transaksi', function($q) use ($anggota) {
                $q->where('anggota_id', $anggota->id)
                  ->where('status', 'dipinjam');
            })
            ->firstOrFail();
            
        $transaksi = $detail->transaksi;
        
        // Update detail
        $denda = $detail->hitungDenda();
        
        $statusDenda = $denda > 0 ? 'belum_lunas' : 'bebas_denda';
        
        $detail->update([
            'tanggal_kembali' => now(),
            'status' => 'dikembalikan',
            'denda_keterlambatan' => $denda,
            'status_denda' => $statusDenda,
        ]);
        
        // Increse stock
        $detail->buku->increment('stok', $detail->jumlah);
        
        // Add denda to transaksi sum
        if ($denda > 0) {
            $transaksi->increment('denda', $denda);
        }
        
        // Check if all details in this transaction are returned
        if ($transaksi->semuaDikembalikan()) {
            $transaksi->update([
                'tanggal_kembali' => now(),
                'status' => 'dikembalikan',
            ]);
        }
        
        $msg = 'Buku berhasil dikembalikan!';
        if ($denda > 0) {
            $msg .= ' Denda keterlambatan buku ini: Rp' . number_format($denda, 0, ',', '.');
        }
        
        return back()->with('success', $msg);
    }

    /**
     * Tampilkan denah letak rak
     */
    public function rakIndex(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();
        
        // Mengambil semua Rak beserta kategorinya untuk divisualisasikan
        $raks = \App\Models\Rak::with('kategoris.bukus')->orderBy('nama_rak')->get();
        
        return view('anggota.rak.index', compact('anggota', 'raks'));
    }

    /**
     * Tampilkan isi mendetail dari satu rak
     */
    public function rakShow($rak_id)
    {
        $anggota = Auth::guard('anggota')->user();
        
        $rak = \App\Models\Rak::with(['kategoris.bukus' => function($q) {
            $q->orderBy('judul', 'asc');
        }])->findOrFail($rak_id);

        return view('anggota.rak.show', compact('anggota', 'rak'));
    }

    /**
     * Cetak Bukti Transaksi — Preview / Stream / Download
     */
    public function cetakBukti(Request $request, $id)
    {
        $anggota = Auth::guard('anggota')->user();
        $transaksi = \App\Models\Transaksi::with('detailTransaksi.buku.kategori.rak')
            ->where('id', $id)
            ->where('anggota_id', $anggota->id)
            ->firstOrFail();

        $pdf = Pdf::loadView('anggota.cetak-bukti', compact('anggota', 'transaksi'))->setPaper('a5', 'portrait');
        
        $filename = 'Bukti_Transaksi_'.$transaksi->id.'.pdf';

        // Mode download
        if ($request->has('download')) {
            return $pdf->download($filename);
        }

        // Mode stream (untuk iframe)
        if ($request->has('stream')) {
            return $pdf->stream($filename);
        }

        // Mode preview
        return view('components.preview-pdf', [
            'title' => 'Bukti Transaksi #TRX-' . str_pad($transaksi->id, 5, '0', STR_PAD_LEFT),
            'streamUrl' => route('anggota.cetak_bukti', ['id' => $transaksi->id, 'stream' => 1]),
            'downloadUrl' => route('anggota.cetak_bukti', ['id' => $transaksi->id, 'download' => 1]),
            'backUrl' => route('anggota.riwayat'),
        ]);
    }
}
