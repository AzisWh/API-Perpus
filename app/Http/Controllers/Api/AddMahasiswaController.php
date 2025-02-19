<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class AddMahasiswaController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    public function addMahasiswa(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
            'fakultas' => 'required|string',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan'
        ]);

        $mahasiswa = Mahasiswa::create($request->all());

        return response()->json($mahasiswa, 201);
    }

    public function getMhs()
    {
        $mhs = Mahasiswa::all();
        return response()->json($mhs);
    }
}
