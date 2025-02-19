<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelBuku;
use App\Models\ModelPeminjaman;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PeminjamanController extends Controller
{
    public function pinjamBuku(Request $request)
    {

        $request->validate([
            'id_buku' => 'required|exists:table_buku,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
        ]);

        $buku = ModelBuku::find($request->id_buku);
        if (!$buku) {
            return response()->json([
                'message' => 'ID buku tidak ditemukan'
            ], 404);
        }

        if ($buku->jumlah_buku <= 0) {
            return response()->json([
                'message' => 'Buku sedang kosong',
                'jumlah_buku' => $buku->jumlah_buku
            ], 400);
        }

        $peminjaman = ModelPeminjaman::create([
            'id_mahasiswa' => $request->id_mahasiswa,
            'id_buku' => $request->id_buku,
            'fakultas' => $request->fakultas,
            'nim' => $request->nim,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => 'menunggu acc',
        ]);

        return response()->json($peminjaman, 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $peminjaman = ModelPeminjaman::findOrFail($id);

        $request->validate(['status' => 'required|in:acc,dipinjam']);

        if (!$id) {
            return response()->json([
                'message' => 'ID tidak ditemukan'
            ], 404);
        }

        if ($request->status == 'acc') {
            $peminjaman->update(['status' => 'dipinjam']);

            $buku = ModelBuku::findOrFail($peminjaman->id_buku);
            $buku->decrement('jumlah_buku');

            return response()->json([
                'message' => 'Buku berhasil dipinjam', 
                'peminjaman' => $peminjaman, 
                'jumlah buku' => $buku
            ], 200);
        }

        return response()->json(['error' => 'Status tidak valid'], 400);
    }

    public function getAllPeminjaman()
    {
        $peminjaman = ModelPeminjaman::with(['buku', 'mahasiswa'])->get(); 
        return response()->json($peminjaman, 200);
    }

    public function getPeminjamanByMahasiswa($id_mahasiswa)
    {
        $peminjaman = ModelPeminjaman::with(['buku', 'mahasiswa'])
            ->where('id_mahasiswa', $id_mahasiswa)
            ->get();

        if (!$id_mahasiswa) {
            return response()->json([
                'message' => 'ID mahasiswa tidak ditemukan'
            ], 404);
        }
        
        if ($peminjaman->isEmpty()) {
            return response()->json(['message' => 'Data peminjaman tidak ditemukan untuk mahasiswa ini'], 404);
        }

        return response()->json($peminjaman, 200);
    }
}
