<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rak;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $raks = Rak::all();
        return view('admin.rak.index', compact('raks'));
    }

    public function create()
    {
        return view('admin.rak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
        ]);
        Rak::create($request->all());
        return redirect()->route('rak.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    public function edit(Rak $rak)
    {
        return view('admin.rak.edit', compact('rak'));
    }

    public function update(Request $request, Rak $rak)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
        ]);
        $rak->update($request->all());
        return redirect()->route('rak.index')->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Rak $rak)
    {
        if ($rak->bukus()->count() > 0) {
            return redirect()->route('rak.index')->with('error', 'Rak tidak dapat dihapus karena masih digunakan pada buku.');
        }
        $rak->delete();
        return redirect()->route('rak.index')->with('success', 'Rak berhasil dihapus.');
    }
}
