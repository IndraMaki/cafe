@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-2xl font-semibold mb-3">Daftar Meja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.meja.create') }}" class="btn bg-yellow-500 hover:bg-yellow-600 text-white mb-6">+ Tambah Meja</a>

    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-300 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nomor Meja</th>
                    <th class="px-4 py-3 text-left">QR Code</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($mejas as $key => $meja)
                    <tr class="bg-white hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $key + 1 }}</td>
                        <td class="px-4 py-2 font-medium text-gray-900">{{ $meja->nomor_meja }}</td>
                        <td class="px-4 py-2">
                            {!! QrCode::size(70)->generate(url('/login') . '?nomor_meja=' . $meja->nomor_meja) !!}
                        </td>

                        <td class="px-4 py-2 space-x-2">
                            <form action="{{ route('admin.meja.destroy', $meja->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus meja ini?');">
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
