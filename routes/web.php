<?php

use App\Http\Controllers\View\AuthController;
use App\Http\Controllers\View\DashboardController;
use App\Http\Controllers\View\Petugas\AccController;
use App\Http\Controllers\View\Petugas\AuthController as PetugasAuthController;
use App\Http\Controllers\View\Petugas\BukuController;
use App\Http\Controllers\View\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\View\Petugas\DashboardPetugas;
use App\Http\Controllers\View\Petugas\PetugasAuth;
use App\Http\Controllers\View\RiwayatPeminjamanController;
use App\Http\Controllers\View\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('mhs.login');

Route::middleware('check.mahasiswa')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('mhs.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('mhs.dashboard');
    Route::get('/buku', [DashboardController::class, 'buku'])->name('mhs.buku');

    // pinjam
    Route::post('/pinjam-buku', [DashboardController::class, 'pinjamBuku'])->name('mhs.pinjamBuku');
    
    Route::post('/pengembalian',[DashboardController::class, 'pengembalianBuku'])->name('mhs.pengembalian');

    Route::get('/riwayat', [RiwayatPeminjamanController::class, 'index'])->name('mhs.riwayat');
    
});

Route::get('login-petugas', [PetugasAuth::class,'index'])->name('login.petugas');
Route::post('login-petugas',[PetugasAuth::class,'login'])->name('loginfungsi.petugas');

Route::middleware('check.petugas')->group(function () {
    Route::post('/logout', [PetugasAuth::class, 'logout'])->name('petugas.logout');

    Route::get('/dashboard-petugas', [DashboardPetugas::class,'index'])->name('petugas.dashboard');
    Route::get('/dashboard-buku', [BukuController::class,'index'])->name('petugas.buku');

    Route::get('/dashboard-peminjaman',[AccController::class,'peminjaman'])->name('petugas.peminjaman');
    Route::post('/api/update-status/{id}', [AccController::class, 'updateStatusPeminjaman']);
    Route::delete('/peminjaman/{id}', [AccController::class, 'destroyPeminjaman'])->name('peminjaman.destroy');

    Route::get('/dashboard-pengembalian',[AccController::class,'pengembalian'])->name('petugas.pengembalian');
    Route::post('/api/acc-pengembalian/{id}', [AccController::class, 'updateStatusPengembalian']);
    Route::delete('/api/pengembalian/{id}', [AccController::class, 'destroy'])->name('pengembalian.destroy');

});


