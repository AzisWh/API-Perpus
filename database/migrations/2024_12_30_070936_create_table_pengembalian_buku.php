<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('table_pengembalian_buku', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedBigInteger('id_peminjaman_buku');
    //         $table->unsignedBigInteger('id_mahasiswa');
    //         $table->unsignedBigInteger('id_petugas')->nullable();
    //         $table->unsignedBigInteger('id_buku');
    //         $table->string('fakultas');
    //         $table->string('nim');
    //         $table->date('tanggal_peminjaman');
    //         $table->date('tanggal_pengembalian');
    //         $table->decimal('denda', 10, 2)->nullable()->default(0);
    //         $table->enum('status', ['menunggu acc', 'dipinjam', 'dikembalikan'])->default('menunggu acc');

    //         $table->foreign('id_peminjaman_buku')->references('id')->on('table_peminjaman_buku')->onDelete('cascade');
    //         $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('table_mahasiswa')->onDelete('cascade');
    //         $table->foreign('id_petugas')->references('id_petugas')->on('table_petugas')->onDelete('cascade');
    //         $table->foreign('id_buku')->references('id_buku')->on('table_buku')->onDelete('cascade');
    //         $table->timestamps();
        
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_pengembalian_buku');
    }
};
