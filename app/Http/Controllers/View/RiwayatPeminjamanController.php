<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        $user = Session::get('user');
        $id_mahasiswa = $user['id'];

        $peminjamanResponse = Http::get(env('API_URL') . 'peminjaman/mahasiswa/' . $id_mahasiswa);
        $peminjamanData = $peminjamanResponse->successful() ? $peminjamanResponse->json() : [];

        $pengembalianResponse = Http::get(env('API_URL') . 'pengembalian/mahasiswa/' . $id_mahasiswa);
        $pengembalianData = $pengembalianResponse->successful() ? $pengembalianResponse->json() : [];
        
        if (!$peminjamanResponse->successful() || !$pengembalianResponse->successful()) {
            return view('mhs.riwayat', [
                'riwayat' => $peminjamanData,
                'pengembalian' => $pengembalianData,
                ])->with('error', 'Gagal memuat data riwayat.');
            }
            // $pengembalianIds = collect($pengembalianData)->pluck('peminjaman_id')->toArray();
            // dd($pengembalianIds);
    
        return view('mhs.riwayat', [
            'riwayat' => $peminjamanData,
            'pengembalian' => $pengembalianData
        ]);
    }
}