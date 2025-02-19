<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\ModelPetugasPerpus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function loginPetugas(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $petugas = ModelPetugasPerpus::where('email', $request->email)->first();

        if (!$petugas || !Hash::check($request->password, $petugas->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = JWTAuth::fromUser($petugas);
        $petugas->save();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'petugas' => $petugas,
        ]);
    }

    public function getPetugas()
    {
        $petugas = ModelPetugasPerpus::all();
        return response()->json($petugas);
    }

    public function loginMhs(Request $request)
    {
        try{
            $request->validate([
                'nama' => 'required|string',
                'nim' => 'required|string',
            ]);
    
            $mhs = Mahasiswa::where('nama', $request->nama)->where('nim', $request->nim)->first();
    
            if (!$mhs) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            $token = JWTAuth::fromUser($mhs);
            $mhs->save();
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'mhs' => $mhs,
            ]);
        }catch (\Exception $e){
            dd($e);
            return $e;
        }
        
    }

    public function logout()
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            return response()->json([
                'success' => 200,
                'message' => 'Logout Berhasil!',  
            ]);
        }
    }
}
