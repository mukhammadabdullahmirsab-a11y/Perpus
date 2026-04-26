<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with(['kategori.rak'])->get();
        $kategoris = Kategori::all();
        $raks = Rak::all();
        return view('admin.buku', compact('buku', 'kategoris', 'raks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'nullable|string|max:2000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'kategori_id' => 'nullable|exists:kategoris,id',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        Buku::create($validated);
        return back()->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.show', compact('buku'));
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();
        $raks = Rak::all();
        return view('admin.buku.edit', compact('buku', 'kategoris', 'raks'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'nullable|string|max:2000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'kategori_id' => 'nullable|exists:kategoris,id',
        ]);

        if ($request->hasFile('cover_image')) {
            // Hapus cover lama jika ada
            if ($buku->cover_image && \Storage::disk('public')->exists($buku->cover_image)) {
                \Storage::disk('public')->delete($buku->cover_image);
            }
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        $buku->update($validated);
        return redirect()->route('buku.show', $buku->id)->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus cover image jika ada
        if ($buku->cover_image && \Storage::disk('public')->exists($buku->cover_image)) {
            \Storage::disk('public')->delete($buku->cover_image);
        }

        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
