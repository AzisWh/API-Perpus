<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{

    // public function __construct()
    // {
    //     ini_set('max_execution_time', 1200);
    // }
    
    public function index()
    {
        return view("auth.loginmhs");
    }

    public function login(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
        ]);

        try{
            $response = Http::post(env('API_URL') . 'loginMhs', [
                'nama' => $request->nama,
                'nim' => $request->nim,
            ]);

            if ($response->status() === 200) {
                $data = $response->json();
                // dd($data);
                Session::put('access_token', $data['access_token']);
                Session::put('user_type', 'mahasiswa');
                Session::put('user', [
                    'id'  => $data['mhs']['id'],
                    'nama' => $data['mhs']['nama'],       
                    'nim' => $data['mhs']['nim'],
                    'fakultas' => $data['mhs']['fakultas'],
                    'jenis_kelamin' => $data['mhs']['jenis_kelamin'],
                ]);
    
                Alert::success('Login Berhasil', 'Welcome, ' . $request->nama . '!');
    
                return redirect()->route('mhs.dashboard');
    
            } else {
                Alert::error('Login Gagal', 'Nama atau NIM tidak valid.');
                return back();
            }
        }catch(\Exception $e){
            dd($e);
        }
    }

    public function logout(Request $request)
    {
        $token = Session::get('access_token');

        if ($token) {
            Http::withToken($token)->post(env('API_URL') . 'logout');
        }

        Session::forget('access_token');
        Session::forget('user_type');

        Alert::success('berhasil logout');
        return redirect()->route('login');
    }
}
