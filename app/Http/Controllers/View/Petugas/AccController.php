<?php

namespace App\Http\Controllers\View\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ModelBuku;
use App\Models\ModelPeminjaman;
use App\Models\ModelPengembalian;
use Illuminate\Http\Request;

class AccController extends Controller
{
    public function peminjaman()
    {
        $peminjaman = ModelPeminjaman::all();

        return view("petugas.peminjaman", [
            'peminjaman' => $peminjaman
        ]);
    }

    public function updateStatusPeminjaman(Request $request, $id)
    {
        $peminjaman = ModelPeminjaman::findOrFail($id);

        $request->validate([
            'status' => 'required|in:acc,dipinjam'
        ]);

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

        // If status is invalid
        return response()->json(['error' => 'Status tidak valid'], 400);
    }

    public function destroyPeminjaman($id)
    {
        $peminjaman = ModelPeminjaman::find($id);

        if (!$peminjaman) {
            return response()->json([
                'message' => 'Data peminjaman tidak ditemukan'
            ], 404);
        }

        $peminjaman->delete();

        return response()->json([
            'message' => 'Peminjaman berhasil dihapus'
        ], 200);
    }

    public function pengembalian()
    {
        $pengembalian = ModelPengembalian::all();
        return view('petugas.pengembalian', [
            'pengembalian' => $pengembalian
        ]);
    }

    public function updateStatusPengembalian(Request $request, $id)
    {
        $pengembalian = ModelPengembalian::findOrFail($id);

        $request->validate([
            'status' => 'required|in:acc,tidak acc'
        ]);

        if (!$id) {
            return response()->json([
                'message' => 'ID tidak ditemukan'
            ], 404);
        }

        if ($request->status == 'acc') {
            $pengembalian->update(['status' => 'dikembalikan']); 

            $peminjaman = ModelPeminjaman::find($pengembalian->id_peminjaman_buku);
            if ($peminjaman) {
                $peminjaman->update(['status' => 'dikembalikan']); 
            }

            $buku = ModelBuku::find($pengembalian->id_buku);
            if ($buku) {
                $buku->increment('jumlah_buku');  
            }

            return response()->json([
                'message' => 'Buku berhasil dikembalikan',
                'pengembalian' => $pengembalian,
                'jumlah buku' => $buku
            ], 200);
        }

        return response()->json(['error' => 'Status tidak valid'], 400);
    }

    public function destroyPengembalian($id)
    {
        $pengembalian = ModelPengembalian::find($id);

        if (!$pengembalian) {
            return response()->json([
                'message' => 'Data pengembalian tidak ditemukan'
            ], 404);
        }

        $pengembalian->delete();

        return response()->json([
            'message' => 'Pengembalian berhasil dihapus'
        ], 200);
    }
}
