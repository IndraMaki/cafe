@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-2xl font-semibold mb-3">Daftar Kategori</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah Kategori -->
    <a href="{{ route('admin.kategori') }}" class="btn btn-primary mb-6">+ Tambah Kategori</a>

    <!-- Tabel Kategori -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Logo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>
                        @if($item->logo)
                            <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo" class="img-thumbnail" style="max-width: 50px;">
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
