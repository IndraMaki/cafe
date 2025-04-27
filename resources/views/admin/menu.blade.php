@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-2xl font-semibold mb-3">Manajemen Menu</h2>
    
    <!-- Tombol Tambah Menu -->
    <a href="{{ route('admin.menu.create') }}" class="btn bg-yellow-500 hover:bg-yellow-600 text-white mb-6">+ Tambah Menu</a>
    
    <!-- Tabel Menu -->
    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-300 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Deskripsi</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Gambar</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($menus as $menu)
                <tr class="bg-white hover:bg-gray-50 transition">
                    <td class="px-4 py-2">{{ $menu->id }}</td>
                    <td class="px-4 py-2 font-medium text-gray-900">{{ $menu->nama_makanan }}</td>
                    <td class="px-4 py-2 w-72">{{ $menu->deskripsi }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $menu->kategori->nama_kategori }}</td>
                    <td class="px-4 py-2">
                        @if ($menu->gambar)
                            <img src="{{ asset('storage/' . $menu->gambar) }}" class="w-24 rounded-md h-auto">
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <form action="{{ route('admin.menu.edit', $menu->id) }}" method="GET" class="inline-block">
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-orange-600 bg-orange-100 hover:bg-orange-200 rounded-md transition">
                                ✏️ Edit
                            </button>
                        </form>

                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"  class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-100 hover:bg-red-200 rounded-md transition">
                                🗑️ Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection