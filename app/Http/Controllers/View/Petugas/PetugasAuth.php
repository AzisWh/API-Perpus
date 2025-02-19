<?php

namespace App\Http\Controllers\View\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class PetugasAuth extends Controller
{
    public function index()
    {
        return view("auth.loginpetugas");
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try{
            $response = Http::post(env('API_URL') . 'loginPetugas', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->status() === 200) {
                $data = $response->json();
                // dd($data);
                Session::put('access_token', $data['access_token']);
                Session::put('user_type', 'petugas');
                Session::put('user', [
                    'id'  => $data['petugas']['id'],
                    'nama' => $data['petugas']['nama'],       
                    'email' => $data['petugas']['email'],
                ]);
    
                Alert::success('Login Berhasil', 'Welcome, ' . $data['petugas']['nama'] . '!');
    
                return redirect()->route('petugas.dashboard');
    
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
        return redirect()->route('login.petugas');
    }
}
