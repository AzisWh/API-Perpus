@extends('layout.layoutmhs')

@section('title', 'Riwayat Peminjaman dan Pengembalian')

@section('content')
    <section class="hero bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Halaman Riwayat</h1>
            <p class="lead">Temukan berbagai sumber daya untuk menunjang pembelajaranmu di perpustakaan kami.</p>
        </div>
    </section>

    <div class="container mt-5">
        <h2>Riwayat Peminjaman</h2>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (count($riwayat) > 0)
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['buku']['judul'] }}</td>
                            <td>{{ $item['buku']['kategori'] }}</td>
                            <td>{{ $item['tanggal_peminjaman'] }}</td>
                            <td>{{ $item['tanggal_pengembalian'] ?? '-' }}</td>
                            <td>
                                @if ($item['status'] === 'menunggu acc')
                                    <span class="badge bg-warning text-dark">{{ $item['status'] }}</span>
                                @elseif($item['status'] === 'dikembalikan')
                                    <span class="badge bg-success">{{ $item['status'] }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item['status'] }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($item['status'] === 'menunggu acc' || $item['status'] === 'dikembalikan')
                                    <button class="btn btn-secondary btn-sm" disabled>Pengajuan Tertutup</button>
                                @else
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#pengembalianModal" data-id="{{ $item['id'] }}"
                                        data-judul="{{ $item['buku']['judul'] }}">
                                        Ajukan Pengembalian
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">Tidak ada riwayat peminjaman.</p>
        @endif

        <h2 class="mt-5">Riwayat Pengembalian</h2>
        @if (count($pengembalian) > 0)
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengembalian as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            {{-- <td>{{ $item['buku']['judul'] }}</td> --}}
                            <td>{{ $item['tanggal_pengembalian'] }}</td>
                            <td>Rp {{ number_format($item['denda'], 0, ',', '.') }}</td>
                            <td>
                                @if ($item['status'] === 'menunggu acc')
                                    <span class="badge bg-warning text-dark">{{ $item['status'] }}</span>
                                @elseif($item['status'] === 'dikembalikan')
                                    <span class="badge bg-success">{{ $item['status'] }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">Tidak ada riwayat pengembalian.</p>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pengembalianModal" tabindex="-1" aria-labelledby="pengembalianModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="pengembalianForm" method="POST" action="{{ route('mhs.pengembalian') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="pengembalianModalLabel">Ajukan Pengembalian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_peminjaman_buku" id="idPeminjaman">
                        <div class="mb-3">
                            <label for="judulBuku" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="judulBuku" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalPengembalian" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="tanggalPengembalian" name="tanggal_pengembalian"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const pengembalianModal = document.getElementById('pengembalianModal');
        pengembalianModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const judul = button.getAttribute('data-judul');

            const modalTitle = pengembalianModal.querySelector('.modal-title');
            const idPeminjamanInput = pengembalianModal.querySelector('#idPeminjaman');
            const judulBukuInput = pengembalianModal.querySelector('#judulBuku');

            idPeminjamanInput.value = id;
            judulBukuInput.value = judul;
        });
    </script>
@endsection
