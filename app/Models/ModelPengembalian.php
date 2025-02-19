<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPengembalian extends Model
{
    use HasFactory;

    protected $table = 'table_pengembalian_buku';

    protected $fillable = [
        'id_peminjaman_buku',
        'id_mahasiswa',
        'id_petugas',
        'id_buku',
        'fakultas',
        'nim',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'denda',
        'status'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(ModelPeminjaman::class, 'id_peminjaman_buku');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function buku()
    {
        return $this->belongsTo(ModelBuku::class, 'id_buku');
    }
}
