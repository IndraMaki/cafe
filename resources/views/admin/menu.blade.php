@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Manajemen Menu</h2>
    
    <!-- Tombol Tambah Menu -->
    <a href="{{ route('admin.menu.create') }}" class="btn btn-success mb-3">Tambah Menu</a>
    
    <!-- Tabel Menu -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Makanan</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menus as $menu)
            <tr>
                <td>{{ $menu->id }}</td>
                <td>{{ $menu->nama_makanan }}</td>
                <td>{{ $menu->deskripsi }}</td>
                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                <td>{{ $menu->kategori->nama_kategori }}</td>
                <td>
                    @if ($menu->gambar)
                        <img src="{{ asset('storage/' . $menu->gambar) }}" width="50">
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" class="d-inline">
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
@endsection