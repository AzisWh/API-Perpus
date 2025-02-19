@extends('layout.layoutpetugas')

@section('title', 'Petugas Dashboard')

@section('content')
    <section class="hero bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">List Pengembalian</h1>
        </div>
    </section>

    <div class="container mt-4">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Judul Buku</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengembalian as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->peminjaman->nim }} - {{ $item->mahasiswa->nama }} - {{ $item->peminjaman->fakultas }}
                        </td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>
                            <span class="badge {{ $item->status == 'dikembalikan' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateStatusModal"
                                data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                                Ubah Status
                            </button>

                            <button class="btn btn-danger btn-sm" onclick="deletePengembalian({{ $item->id }})">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal for Status Change -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">Ubah Status Pengembalian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateStatusForm" method="POST" action="{{ url('/api/acc-pengembalian') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="pengembalianId">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="acc">Acc</option>
                                    <option value="tidak acc">Tidak Acc</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deletePengembalian(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data pengembalian ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/pengembalian/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data Terhapus!',
                                    text: data.message,
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan saat menghapus data',
                                });
                            }
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server',
                            });
                        });
                }
            });
        }

        // Show Modal for Update Status Pengembalian
        const updateStatusModal = document.getElementById('updateStatusModal');
        updateStatusModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const pengembalianId = button.getAttribute('data-id');
            const currentStatus = button.getAttribute('data-status');

            const modal = this;
            modal.querySelector('#pengembalianId').value = pengembalianId;
            modal.querySelector('#status').value = currentStatus;
        });


        // Handle the Form Submission for Updating Status Pengembalian
        document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const id = form.querySelector('#pengembalianId').value;
            const status = form.querySelector('#status').value;

            fetch(`/api/acc-pengembalian/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Diperbarui!',
                            text: data.message,
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server',
                    });
                });
        });
    </script>

@endsection
