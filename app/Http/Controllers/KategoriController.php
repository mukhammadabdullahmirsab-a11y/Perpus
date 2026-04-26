<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        $raks = \App\Models\Rak::all();
        return view('admin.kategori.create', compact('raks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'rak_id' => 'required|exists:raks,id'
        ]);
        Kategori::create($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori dan prasetel Lokasi Rak berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        $raks = \App\Models\Rak::all();
        return view('admin.kategori.edit', compact('kategori', 'raks'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'rak_id' => 'required|exists:raks,id'
        ]);
        $kategori->update($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori beserta Lokasi Rak berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->bukus()->count() > 0) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan pada buku.');
        }
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
