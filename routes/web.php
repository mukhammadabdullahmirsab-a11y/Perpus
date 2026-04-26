<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AnggotaAuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RakController;

Route::resource('buku', BukuController::class);

// Admin Transaksi & Anggota Routes
Route::middleware('auth')->group(function () {
    Route::get('/transaksi/approval', [TransaksiController::class, 'approval'])->name('transaksi.approval');
    Route::post('/transaksi/{transaksi}/approve', [TransaksiController::class, 'approve'])->name('transaksi.approve');
    Route::post('/transaksi/{transaksi}/reject', [TransaksiController::class, 'reject'])->name('transaksi.reject');
    
    Route::resource('transaksi', TransaksiController::class);
    Route::post('/transaksi/kembalikan/{detail}', [TransaksiController::class, 'kembalikanDetail'])->name('transaksi.kembalikan_detail');
    Route::get('/transaksi/{transaksi}/cetak', [TransaksiController::class, 'cetakBukti'])->name('transaksi.cetak_bukti');

    Route::get('/rekapan-denda', [\App\Http\Controllers\DendaController::class, 'indexAdmin'])->name('admin.denda.index');
    Route::post('/rekapan-denda/{detail}/lunasi', [\App\Http\Controllers\DendaController::class, 'lunasi'])->name('admin.denda.lunasi');

    // Master Data
    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::resource('rak', RakController::class)->except(['show']);

    Route::resource('kelola-anggota', AnggotaController::class)->parameters(['kelola-anggota' => 'anggotum']);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::get('/statistik', [\App\Http\Controllers\StatistikController::class, 'index'])->name('admin.statistik');
});



Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::get('/dashboard', function () {
    $totalBuku = \App\Models\Buku::count();
    $totalAnggota = \App\Models\Anggota::count();
    $totalPeminjaman = \App\Models\Transaksi::where('status', 'dipinjam')->count();
    $totalTerlambat = \App\Models\Transaksi::where('status', 'dipinjam')
        ->where(function($q) {
            $q->whereNotNull('tanggal_pengembalian')
              ->where('tanggal_pengembalian', '<', now())
              ->orWhere(function($q2) {
                  $q2->whereNull('tanggal_pengembalian')
                     ->where('tanggal_pinjam', '<', now()->subDays(7));
              });
        })
        ->count();
    
    return view('dashboard', compact('totalBuku', 'totalAnggota', 'totalPeminjaman', 'totalTerlambat'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// ANGGOTA ROUTES
// ==========================================

// Guest anggota routes (belum login)
Route::middleware('guest:anggota')->group(function () {
    Route::get('/anggota/login', [AnggotaAuthController::class, 'showLoginForm'])->name('anggota.login');
    Route::post('/anggota/login', [AnggotaAuthController::class, 'login'])->name('anggota.login.submit');
    Route::get('/anggota/register', [AnggotaAuthController::class, 'showRegisterForm'])->name('anggota.register');
    Route::post('/anggota/register', [AnggotaAuthController::class, 'register'])->name('anggota.register.submit');
    
    // Forgot Password Routes
    Route::get('/anggota/lupa-password', [AnggotaAuthController::class, 'showForgotPasswordForm'])->name('anggota.password.request');
    Route::post('/anggota/lupa-password', [AnggotaAuthController::class, 'verifyForgotPassword'])->name('anggota.password.verify');
    Route::get('/anggota/reset-password', [AnggotaAuthController::class, 'showResetPasswordForm'])->name('anggota.password.reset');
    Route::post('/anggota/reset-password', [AnggotaAuthController::class, 'resetPassword'])->name('anggota.password.update');
});

// Authenticated anggota routes (sudah login)
Route::middleware('auth:anggota')->group(function () {
    Route::get('/anggota/dashboard', [AnggotaAuthController::class, 'dashboard'])->name('anggota.dashboard');
    Route::get('/anggota/katalog', [AnggotaAuthController::class, 'katalog'])->name('anggota.katalog');
    Route::get('/anggota/katalog/{buku}', [AnggotaAuthController::class, 'detailBuku'])->name('anggota.katalog.detail');
    Route::get('/anggota/rak/{rak}', [AnggotaAuthController::class, 'rakShow'])->name('anggota.rak.show');
    Route::post('/anggota/pinjam/{buku_id}', [AnggotaAuthController::class, 'pinjamBuku'])->name('anggota.pinjam');
    Route::post('/anggota/keranjang/tambah/{buku_id}', [AnggotaAuthController::class, 'tambahKeranjang'])->name('anggota.keranjang.tambah');
    Route::post('/anggota/keranjang/hapus/{buku_id}', [AnggotaAuthController::class, 'hapusKeranjang'])->name('anggota.keranjang.hapus');
    Route::get('/anggota/keranjang', [AnggotaAuthController::class, 'keranjang'])->name('anggota.keranjang');
    Route::post('/anggota/keranjang/checkout', [AnggotaAuthController::class, 'checkoutKeranjang'])->name('anggota.keranjang.checkout');
    Route::get('/anggota/riwayat', [AnggotaAuthController::class, 'riwayatPinjam'])->name('anggota.riwayat');
    Route::post('/anggota/kembalikan/{detail_id}', [AnggotaAuthController::class, 'kembalikanDetail'])->name('anggota.kembalikan');
    Route::get('/anggota/transaksi/{id}/cetak', [AnggotaAuthController::class, 'cetakBukti'])->name('anggota.cetak_bukti');
    Route::get('/anggota/rekapan-denda', [\App\Http\Controllers\DendaController::class, 'indexAnggota'])->name('anggota.denda.index');
    Route::get('/anggota/profile', [AnggotaAuthController::class, 'profile'])->name('anggota.profile');
    Route::put('/anggota/profile', [AnggotaAuthController::class, 'updateProfile'])->name('anggota.profile.update');
    Route::put('/anggota/profile/password', [AnggotaAuthController::class, 'updatePassword'])->name('anggota.profile.password');
    Route::post('/anggota/logout', [AnggotaAuthController::class, 'logout'])->name('anggota.logout');
});

require __DIR__.'/auth.php';

