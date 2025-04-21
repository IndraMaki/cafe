@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-2xl font-semibold mb-3">Daftar Kategori</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah Kategori -->
    <a href="{{ route('admin.kategori') }}" class="btn bg-yellow-500 hover:bg-yellow-600 text-white mb-6">+ Tambah Kategori</a>

    <!-- Tabel Kategori -->
    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-300 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Kategori</th>
                    <th class="px-4 py-3 text-left">Logo</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($kategori as $key => $item)
                    <tr class="bg-white hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $key + 1 }}</td>
                        <td class="px-4 py-2 font-medium text-gray-900">{{ $item->nama_kategori }}</td>
                        <td class="px-4 py-2">
                            @if($item->logo)
                                <img src="{{ asset('storage/' . $item->logo) }}" alt="Logo" class="h-10 w-10 rounded-md object-cover">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.kategori.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-orange-600 bg-orange-100 hover:bg-orange-200 rounded-md transition">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-100 hover:bg-red-200 rounded-md transition">
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
