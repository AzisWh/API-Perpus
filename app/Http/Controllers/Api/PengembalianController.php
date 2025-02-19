<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelBuku;
use App\Models\ModelPeminjaman;
use App\Models\ModelPengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_peminjaman_buku' => 'required|exists:table_peminjaman_buku,id',
            'tanggal_pengembalian' => 'required|date',
        ]);

        $peminjaman = ModelPeminjaman::find($validated['id_peminjaman_buku']);

        if (!$validated['id_peminjaman_buku']) {
            return response()->json([
                'status' => 'error',
                'message' => 'ID Peminjaman Buku tidak boleh kosong.'
            ], 400);
        }

        if (!$peminjaman) {
            return response()->json([
                'status' => 'error',
                'message' => 'Peminjaman buku tidak ditemukan.'
            ], 404);
        }

        $id_buku = $peminjaman->id_buku;
        $id_mahasiswa = $peminjaman->id_mahasiswa;
        $fakultas = $peminjaman->mahasiswa->fakultas; 
        $nim = $peminjaman->mahasiswa->nim; 
        $tanggal_peminjaman = Carbon::parse($peminjaman->tanggal_peminjaman);

        $tanggal_pengembalian = Carbon::parse($validated['tanggal_pengembalian']);
        $denda = 0;

        if ($tanggal_pengembalian->gt($tanggal_peminjaman)) {
            $selisih_hari = $tanggal_peminjaman->diffInDays($tanggal_pengembalian);
            $denda = $selisih_hari * 10000; 
        }

        $pengembalian = new ModelPengembalian([
            'id_peminjaman_buku' => $peminjaman->id,
            'id_mahasiswa' => $id_mahasiswa,
            'id_buku' => $id_buku,
            'fakultas' => $fakultas,
            'nim' => $nim,
            'tanggal_peminjaman' => $tanggal_peminjaman,
            'tanggal_pengembalian' => $validated['tanggal_pengembalian'],
            'denda' => $denda,
            'status' => 'menunggu acc',
        ]);
        $pengembalian->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Buku berhasil diajukan untuk dikembalikan.',
            'data' => $pengembalian
        ], 200);

    }

    public function accPengembalian(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:acc,tidak acc',
        ]);

        $pengembalian = ModelPengembalian::find($id);

        if (!$pengembalian) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengembalian buku tidak ditemukan.'
            ], 404);
        }

        if ($pengembalian->status != 'menunggu acc') {
            return response()->json([
                'status' => 'error',
                'message' => 'Status pengembalian sudah diproses.'
            ], 400);
        }

        if ($validated['status'] === 'acc') {
            $pengembalian->status = 'dikembalikan';
            $pengembalian->save(); 
    
            $peminjaman = ModelPeminjaman::find($pengembalian->id_peminjaman_buku);
            if ($peminjaman) {
                $peminjaman->status = 'dikembalikan'; 
                $peminjaman->save();  
            }
    
            $buku = ModelBuku::find($pengembalian->id_buku);
            if ($buku) {
                $buku->increment('jumlah_buku'); 
                $buku->save(); 
            }
        } else {
            $pengembalian->status = 'tidak acc'; 
            $pengembalian->save();  
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Status pengembalian buku telah diperbarui.',
            'data' => $pengembalian 
        ], 200);
    }

    public function getAllPengembalian()
    {
        $pengembalian = ModelPengembalian::with(['peminjaman'])->get(); 
        return response()->json($pengembalian, 200);
    }

    public function getPengembalianByMahasiswa($id_mahasiswa)
    {
        $pengembalian = ModelPengembalian::with(['mahasiswa'])
            ->where('id_mahasiswa', $id_mahasiswa)
            ->get();

        if (!$id_mahasiswa) {
            return response()->json([
                'message' => 'ID mahasiswa tidak ditemukan'
            ], 404);
        }
        
        if ($pengembalian->isEmpty()) {
            return response()->json(['message' => 'Data pengembalian tidak ditemukan untuk mahasiswa ini'], 404);
        }

        return response()->json($pengembalian, 200);
    }
}
