<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view (for anggota).
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request (creates anggota).
     */
    public function store(Request $request): RedirectResponse
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

        Anggota::create([
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'kelas' => $validated['kelas'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }
}
