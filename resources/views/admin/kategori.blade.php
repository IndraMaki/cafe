<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Manajemen Kategori</h2>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tambah Kategori -->
    <form action="{{ route('kategori.store') }}" method="POST" class="mb-3">
        @csrf
        <div class="input-group">
            <input type="text" name="nama" class="form-control" placeholder="Nama Kategori" required>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
    </form>

    <!-- Daftar Kategori -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $kategori)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kategori->nama }}</td>
                <td>
                    <!-- Form Edit -->
                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="text" name="nama" class="form-control d-inline w-50" value="{{ $kategori->nama }}" required>
                        <button type="submit" class="btn btn-success btn-sm">Edit</button>
                    </form>

                    <!-- Form Hapus -->
                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
