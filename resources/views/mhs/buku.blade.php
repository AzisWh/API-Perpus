@extends('layout.layoutmhs')

@section('title', 'List Buku')

@section('content')
    @if (empty($bukuData) || count($bukuData) == 0)
        <section class="hero bg-primary text-white text-center py-5">
            <div class="container">
                <h1 class="display-4">Tidak Ada Buku Tersedia</h1>
                <p class="lead">Saat ini belum ada buku yang tersedia di perpustakaan kami. Harap kembali lagi nanti.</p>
            </div>
        </section>
    @else
        <section class="wrapper">
            <div class="container">
                <div class="row">
                    @foreach ($bukuData as $buku)
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                            <div class="card text-dark card-has-bg click-col"
                                style="background-image: url('{{ $buku['image_buku'] ? asset('storage/' . $buku['image_buku']) : 'https://penerbitdeepublish.com/wp-content/uploads/2017/05/ONU6OU0-e1548298130744-683x1024.jpg' }}');">
                                <div class="card-img-overlay d-flex flex-column">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex flex-row">
                                            <p class="font-italic mb-2">Kategori: {{ $buku['kategori'] }}</p>
                                            <p class="font-italic mb-2 ml-4">Jumlah: {{ $buku['jumlah_buku'] }}</p>
                                        </div>
                                        <h1 class="font-weight-bold mt-0">
                                            <a class="text-dark" href="#">{{ $buku['judul'] }}</a>
                                        </h1>
                                        <small><i class="far fa-clock"></i> Tahun Terbit:
                                            {{ $buku['tahun_terbit'] }}</small>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-success btn-sm"
                                            onclick="showPinjamModal({{ $buku['id'] }}, '{{ $buku['judul'] }}')">Pinjam
                                            Buku</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <div class="modal fade" id="pinjamModal" tabindex="-1" aria-labelledby="pinjamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="pinjamForm" method="POST" action="{{ route('mhs.pinjamBuku') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pinjamModalLabel">Form Pinjam Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_buku" id="id_buku">
                        <div class="mb-3">
                            <label for="judul_buku" class="form-label">Judul Buku:</label>
                            <input type="text" class="form-control" id="judul_buku" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman:</label>
                            <input type="date" class="form-control" name="tanggal_peminjaman" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian:</label>
                            <input type="date" class="form-control" name="tanggal_pengembalian" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Pinjam</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showPinjamModal(id_buku, judul_buku) {
            // Set data ke modal
            document.getElementById('id_buku').value = id_buku;
            document.getElementById('judul_buku').value = judul_buku;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('pinjamModal'));
            modal.show();
        }
    </script>
@endsection
