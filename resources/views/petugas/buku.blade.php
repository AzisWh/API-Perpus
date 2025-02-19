@extends('layout.layoutpetugas')

@section('title', 'Petugas Dashboard')

@section('content')
    <div class="container">
        <h2>Data Buku</h2>

        <!-- Button to trigger Create Book modal -->
        <button class="btn btn-success" onclick="showCreateModal()">Create Buku</button>

        <!-- Table to display all books -->
        <table id="booksTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Tahun Terbit</th>
                    <th>Jumlah Buku</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated dynamically with JavaScript -->
            </tbody>
        </table>

        <!-- Modal for Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Buku</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_kategori" class="form-label">Kategori:</label>
                                <input type="text" class="form-control" id="edit_kategori" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_judul" class="form-label">Judul:</label>
                                <input type="text" class="form-control" id="edit_judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_tahun_terbit" class="form-label">Tahun Terbit:</label>
                                <input type="text" class="form-control" id="edit_tahun_terbit" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_jumlah_buku" class="form-label">Jumlah Buku:</label>
                                <input type="number" class="form-control" id="edit_jumlah_buku" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_image_buku" class="form-label">Image Buku:</label>
                                <input type="file" class="form-control" id="edit_image_buku">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal for Create -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Create Buku</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="create_kategori" class="form-label">Kategori:</label>
                                <input type="text" class="form-control" id="create_kategori" required>
                            </div>
                            <div class="mb-3">
                                <label for="create_judul" class="form-label">Judul:</label>
                                <input type="text" class="form-control" id="create_judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="create_tahun_terbit" class="form-label">Tahun Terbit:</label>
                                <input type="text" class="form-control" id="create_tahun_terbit" required>
                            </div>
                            <div class="mb-3">
                                <label for="create_jumlah_buku" class="form-label">Jumlah Buku:</label>
                                <input type="number" class="form-control" id="create_jumlah_buku" required>
                            </div>
                            <div class="mb-3">
                                <label for="create_image_buku" class="form-label">Image Buku:</label>
                                <input type="file" class="form-control" id="create_image_buku">
                            </div>
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal for Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="detailBody">
                        <!-- Details will be populated dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetch all books
        fetchBooks();

        function fetchBooks() {
            fetch('http://127.0.0.1:8000/api/buku')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector("#booksTable tbody");
                    tbody.innerHTML = '';
                    data.forEach(buku => {
                        const imagePath = buku.image_buku ? `http://127.0.0.1:8000/storage/${buku.image_buku}` :
                            'https://via.placeholder.com/100';
                        const row = `
                        <tr>
                            <td>${buku.kategori}</td>
                            <td>${buku.judul}</td>
                            <td>${buku.tahun_terbit}</td>
                            <td>${buku.jumlah_buku}</td>
                            <td><img src="${imagePath}" alt="Image" width="100" height="auto"></td>
                            <td>
                                <button class="btn btn-info" onclick="viewDetails(${buku.id})">Detail</button>
                                <button class="btn btn-warning" onclick="editBuku(${buku.id})">Edit</button>
                                <button class="btn btn-danger" onclick="deleteBuku(${buku.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                        tbody.innerHTML += row;
                    });
                })
                .catch(error => console.error('Error fetching books:', error));
        }

        // View details of a book inside modal
        function viewDetails(id) {
            fetch(`http://127.0.0.1:8000/api/buku/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailBody').innerHTML = `
                    <p><strong>Judul:</strong> ${data.judul}</p>
                    <p><strong>Kategori:</strong> ${data.kategori}</p>
                    <p><strong>Tahun Terbit:</strong> ${data.tahun_terbit}</p>
                    <p><strong>Jumlah Buku:</strong> ${data.jumlah_buku}</p>
                    <p><strong>Image:</strong> ${data.image_buku ? `<img src="http://127.0.0.1:8000/storage/${data.image_buku}" width="100">` : 'No image available'}</p>
                `;
                    $('#detailModal').modal('show');
                });
        }

        // Edit a book
        function editBuku(id) {
            fetch(`http://127.0.0.1:8000/api/buku/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_kategori').value = data.kategori;
                    document.getElementById('edit_judul').value = data.judul;
                    document.getElementById('edit_tahun_terbit').value = data.tahun_terbit;
                    document.getElementById('edit_jumlah_buku').value = data.jumlah_buku;

                    document.getElementById('editForm').onsubmit = function(e) {
                        e.preventDefault();

                        const formData = new FormData();
                        formData.append('kategori', document.getElementById('edit_kategori').value);
                        formData.append('judul', document.getElementById('edit_judul').value);
                        formData.append('tahun_terbit', document.getElementById('edit_tahun_terbit').value);
                        formData.append('jumlah_buku', document.getElementById('edit_jumlah_buku').value);
                        const imageFile = document.getElementById('edit_image_buku').files[0];
                        if (imageFile) formData.append('image_buku', imageFile);

                        fetch(`http://127.0.0.1:8000/api/buku/${id}`, {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire('Success', 'Buku updated successfully!', 'success');
                                $('#editModal').modal('hide');
                                fetchBooks();
                            })
                            .catch(error => console.error('Error updating book:', error));
                    };

                    $('#editModal').modal('show');
                });
        }

        // Create a new book
        function showCreateModal() {
            document.getElementById('createForm').onsubmit = function(e) {
                e.preventDefault();

                const formData = new FormData();
                formData.append('kategori', document.getElementById('create_kategori').value);
                formData.append('judul', document.getElementById('create_judul').value);
                formData.append('tahun_terbit', document.getElementById('create_tahun_terbit').value);
                formData.append('jumlah_buku', document.getElementById('create_jumlah_buku').value);
                const imageFile = document.getElementById('create_image_buku').files[0];
                if (imageFile) formData.append('image_buku', imageFile);

                fetch('http://127.0.0.1:8000/api/buku', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire('Success', 'Buku created successfully!', 'success');
                        $('#createModal').modal('hide');
                        fetchBooks();
                    })
                    .catch(error => console.error('Error creating book:', error));
            };

            $('#createModal').modal('show');
        }

        // Delete a book
        function deleteBuku(id) {
            if (confirm('Are you sure you want to delete this book?')) {
                fetch(`http://127.0.0.1:8000/api/buku/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire('Deleted!', 'Buku deleted successfully!', 'success');
                        fetchBooks();
                    })
                    .catch(error => console.error('Error deleting book:', error));
            }
        }
    </script>

@endsection
