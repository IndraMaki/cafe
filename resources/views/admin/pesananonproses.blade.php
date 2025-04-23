@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-2xl font-semibold mb-3">Manajemen Pesanan</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-300 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nomor Meja</th>
                    <th class="px-4 py-3 text-left">Nomor Telp</th>
                    <th class="px-4 py-3 text-left">Total Harga</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($menus as $menu)
                <tr class="bg-white hover:bg-gray-50 transition">
                    <td class="px-4 py-2">{{ $menu->id }}</td>
                    <td class="px-4 py-2">{{ $menu->nomor_meja }}</td>
                    <td class="px-4 py-2">{{ $menu->nomor_hp }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">
                        <span class="text-yellow-600 font-semibold">Belum Bayar</span>
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <form action="{{ route('admin.pesanan.destroy', $menu->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-100 hover:bg-red-200 rounded-md transition">
                                Selesai
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
