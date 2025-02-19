<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'table_peminjaman_buku';

    protected $fillable = [
        'id_mahasiswa',
        'id_petugas',
        'id_buku',
        'fakultas',
        'nim',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function buku()
    {
        return $this->belongsTo(ModelBuku::class, 'id_buku');
    }

    public function petugas()
    {
        return $this->belongsTo(ModelPetugasPerpus::class, 'id_petugas');
    }

    public function peminjaman()
    {
        return $this->hasMany(ModelPengembalian::class, 'id_peminjaman_buku');
    }
}
