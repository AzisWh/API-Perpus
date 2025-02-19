<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Mahasiswa extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'table_mahasiswa';

    protected $fillable = ['nama', 'nim', 'fakultas', 'alamat', 'jenis_kelamin'];

    public function getAuthIdentifierName()
    {
        return 'nim';
    }

    public function getAuthIdentifier()
    {
        return $this->nim;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function peminjaman()
    {
        return $this->hasMany(ModelPeminjaman::class, 'id_mahasiswa');
    }
    public function pengembalian()
    {
        return $this->hasMany(ModelPengembalian::class, 'id_mahasiswa');
    }
}
