<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelBuku extends Model
{
    use HasFactory;

    protected $table = 'table_buku';

    protected $fillable = [
        'kategori',
        'judul',
        'tahun_terbit',
        'jumlah_buku',
        'image_buku',
    ];

    public function peminjaman()
    {
        return $this->hasMany(ModelPeminjaman::class, 'id_buku');
    }

    public function pengembalian()
    {
        return $this->hasMany(ModelPengembalian::class, 'id_buku');
    }
}
