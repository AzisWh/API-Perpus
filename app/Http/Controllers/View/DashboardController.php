<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        
        return view('mhs.index');
       
    }

    public function buku()
    {
        $response = Http::get(env('API_URL') . 'buku'); 

        if ($response) {
            $bukuData = $response->json();
            // dd($bukuData);

            return view('mhs.buku', compact('bukuData'));
        } else {
            return view('mhs.buku', ['error' => 'Gagal mengambil data buku']);
        }
    }

    public function pinjamBuku(Request $request)
    {
        $user = Session::get('user');
        // dd($user);
        $response = Http::post(env('API_URL') . 'pinjam-buku', [
            'id_mahasiswa' => $user['id'], 
            'id_buku' => $request->id_buku,
            'fakultas' => $user['fakultas'], 
            'nim' => $user['nim'], 
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);
        // dd($response);
        if ($response->successful()) {
            $data = $response->json();
            Alert::success('Berhasil meminjam buku');
            return redirect()->route('mhs.riwayat');
        } else {
            Alert::error('terjadi kesalahan');
            return redirect()->route('mhs.riwayat');
        }
    }

    public function pengembalianBuku(Request $request)
    {
        $request->validate([
            'id_peminjaman_buku' => 'required|integer|exists:table_peminjaman_buku,id',
            'tanggal_pengembalian' => 'required|date',
        ]);

        $user = Session::get('user');

        $response = Http::post(env('API_URL') . 'pengembalian-buku', [
            'id_peminjaman_buku' => $request->id_peminjaman_buku,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        if ($response->successful()) {
            // dd($response);
            Alert::success('Berhasil mengajukan pengembalian buku');
            return redirect()->route('mhs.riwayat');
        } else {
            // dd($response);
            Alert::error('Terjadi kesalahan saat mengajukan pengembalian buku');
            return redirect()->route('mhs.riwayat');
        }
    }           
}
