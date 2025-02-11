<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu - Food4U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Food4U</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('menu.index') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pesanan.index') }}">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('report.index') }}">Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kategori.index') }}">Add Kategori</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <h2 class="mb-4">Manajemen Menu</h2>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol Tambah Menu -->
        <a href="{{ route('menu.create') }}" class="btn btn-primary mb-3">Tambah Menu</a>

        <!-- Daftar Menu -->
        <h3>Daftar Menu</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                    <tr>
                        <td>{{ $menu->nama }}</td>
                        <td>{{ $menu->keterangan }}</td>
                        <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td>{{ $menu->kategori->nama ?? 'Tidak ada kategori' }}</td>
                        <td>
                            <!-- Memastikan gambar muncul dengan benar -->
                            @if($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" width="80" alt="Gambar Menu">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                        <td>
                            <!-- Tombol Update dan Delete -->
                            <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning btn-sm">Update</a>

                            <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>