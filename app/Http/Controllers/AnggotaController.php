<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Anggota::query();
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by kelas
        if ($request->has('kelas') && $request->kelas != '') {
            $query->where('kelas', $request->kelas);
        }
        
        $anggotas = $query->orderBy('nama', 'asc')->get();
        $kelasList = Anggota::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        
        return view('admin.anggota.index', compact('anggotas', 'kelasList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:anggotas,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'email' => 'required|email|unique:anggotas,email',
            'password' => 'required|string|min:6',
        ], [
            'nis.unique' => 'NIS sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        
        Anggota::create($validated);
        
        return redirect()->route('kelola-anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggotum)
    {
        return view('admin.anggota.edit', ['anggota' => $anggotum]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggotum)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:anggotas,nis,' . $anggotum->id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'email' => 'required|email|unique:anggotas,email,' . $anggotum->id,
            'password' => 'nullable|string|min:6',
        ], [
            'nis.unique' => 'NIS sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
        ]);
        
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        $anggotum->update($validated);
        
        return redirect()->route('kelola-anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggotum)
    {
        // Check if anggota has active transactions
        $activeTransactions = $anggotum->transaksis()->where('status', 'dipinjam')->count();
        
        if ($activeTransactions > 0) {
            return redirect()->route('kelola-anggota.index')->with('error', 'Tidak dapat menghapus anggota yang masih memiliki peminjaman aktif!');
        }
        
        $anggotum->delete();
        
        return redirect()->route('kelola-anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}
