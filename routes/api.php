<?php

use App\Http\Controllers\Api\AddMahasiswaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// logout
Route::post('logout', [AuthController::class, 'logout']);

// petugas
Route::post('loginPetugas', [AuthController::class, 'loginPetugas']);
Route::post('add-mahasiswa', [AddMahasiswaController::class, 'addMahasiswa']);

Route::get('mhs', [AddMahasiswaController::class, 'getMhs']);
Route::get('petugas', [AuthController::class, 'getPetugas']);

// mhs
Route::post('loginMhs', [AuthController::class, 'loginMhs']);

// buku
Route::post('buku', [BukuController::class, 'store']);
Route::patch('buku/{id}', [BukuController::class, 'update']);
Route::delete('buku/{id}', [BukuController::class, 'destroy']);
Route::get('buku/{id}', [BukuController::class, 'show']); 
Route::get('buku', [BukuController::class, 'index']);

// peminjaman
Route::post('pinjam-buku', [PeminjamanController::class, 'pinjamBuku']);
Route::patch('update-status/{id}', [PeminjamanController::class, 'updateStatus']);
// pengembalian
Route::post('/pengembalian-buku', [PengembalianController::class, 'store']);
Route::patch('/acc-pengembalian/{id}', [PengembalianController::class, 'accPengembalian']);

Route::get('/pengembalian', [PengembalianController::class, 'getAllPengembalian']); 
Route::get('/pengembalian/mahasiswa/{id_mahasiswa}', [PengembalianController::class, 'getPengembalianByMahasiswa']);

Route::get('/peminjaman', [PeminjamanController::class, 'getAllPeminjaman']); 
Route::get('/peminjaman/mahasiswa/{id_mahasiswa}', [PeminjamanController::class, 'getPeminjamanByMahasiswa']); 




// Route::group(['middleware' => ['auth:api', 'check.mahasiswa']], function () {
    
// });

// Route::group(['middleware' => ['auth:api', 'check.petugas']], function () {
// });

