@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-2xl font-semibold mb-3">Edit Kategori</h2>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="nama_kategori" class="block mb-1 font-semibold text-gray-700">Nama Kategori</label>
            <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
        </div>

        <div>
            <label for="logo" class="block mb-1 font-semibold text-gray-700">Logo Kategori (opsional)</label>
            <input type="file" id="logo" name="logo" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">

            @if($kategori->logo)
                <div class="mt-3">
                    <p class="text-gray-600 mb-1">Logo saat ini:</p>
                    <div class="w-24 h-14 bg-stone-300 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('storage/' . $kategori->logo) }}" alt="Logo" class="h-10 w-10 object-cover rounded-md">
                    </div>
                </div>
            @endif
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-md">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.viewkategori') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-md">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
