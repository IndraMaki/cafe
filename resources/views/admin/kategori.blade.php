@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Tambah Kategori</h2>

    <!-- Form Tambah Kategori -->
    <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nama Kategori -->
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
        </div>

        <!-- Upload Logo -->
        <div class="mb-3">
            <label for="logo" class="form-label">Upload Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*" onchange="previewImage(event)">
        </div>

        <!-- Preview Gambar -->
        <div class="mb-3">
            <img id="preview" src="" alt="Preview Logo" class="img-thumbnail" style="max-width: 200px; display: none;">
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
