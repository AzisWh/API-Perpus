<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = ModelBuku::all();
        return response()->json($buku,201);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer',
            'jumlah_buku' => 'required|integer',
            'image_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image_buku')) {
            $imageName = $request->file('image_buku')->getClientOriginalName();
            $imagePath = $request->file('image_buku')->storeAs('cover_buku', $imageName, 'public');
        } else {
            $imagePath = null;  
        }

        $buku = ModelBuku::create([
            'kategori' => $request->kategori,
            'judul' => $request->judul,
            'tahun_terbit' => $request->tahun_terbit,
            'jumlah_buku' => $request->jumlah_buku,
            'image_buku' => $imagePath,
        ]);

        return response()->json($buku, 201);
    }

    public function show($id)
    {
        $buku = ModelBuku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'ID tidak ditemukan'
            ], 404);
        }
        return response()->json($buku, 201);
    }

    public function update(Request $request, $id)
    {
        $buku = ModelBuku::findOrFail($id);

        $request->validate([
            'kategori' => 'sometimes|string|max:255',
            'judul' => 'sometimes|string|max:255',
            'tahun_terbit' => 'sometimes|digits:4|integer',
            'jumlah_buku' => 'sometimes|integer',
            'image_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image_buku')) {
            if ($buku->image_buku && file_exists(storage_path('app/public/' . $buku->image_buku))) {
                unlink(storage_path('app/public/' . $buku->image_buku));
            }
    
            $imageName = $request->file('image_buku')->getClientOriginalName();
            
            $imagePath = $request->file('image_buku')->storeAs('cover_buku', $imageName, 'public');
        } else {
            $imagePath = $buku->image_buku;  
        }

        $buku->update([
            'kategori' => $request->kategori ?? $buku->kategori,
            'judul' => $request->judul ?? $buku->judul,
            'tahun_terbit' => $request->tahun_terbit ?? $buku->tahun_terbit,
            'jumlah_buku' => $request->jumlah_buku ?? $buku->jumlah_buku,
            'image_buku' => $imagePath,  
        ]);
        return response()->json($buku, 201);
    }

    public function destroy($id)
    {
        $buku = ModelBuku::findOrFail($id);

        if ($buku->image_buku && file_exists(storage_path('app/public/' . $buku->image_buku))) {
            try {
                unlink(storage_path('app/public/' . $buku->image_buku)); 
            } catch (\Exception $e) {
                return response()->json(['message' => 'Gambar gagal dihapus: ' . $e->getMessage()], 500);
            }
        }

        $buku->delete();
        return response()->json(['message' => 'Buku deleted successfully'], 201);
    }
}
