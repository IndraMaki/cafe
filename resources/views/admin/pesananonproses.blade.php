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
                <tr class="bg-white hover:bg-gray-50 transition cursor-pointer" onclick="showModal({{ $menu->id }})">
                    <td class="px-4 py-2">{{ $menu->id }}</td>
                    <td class="px-4 py-2">{{ $menu->nomor_meja }}</td>
                    <td class="px-4 py-2">{{ $menu->nomor_hp }}</td>
                    <td class="px-4 py-2">
                        Rp {{ number_format($menu->detailPesanan->sum(fn($d) => $d->harga * $d->jumlah), 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2">
                        <span class="text-yellow-600 font-semibold">Belum Bayar</span>
                    </td>
                    <td class="px-4 py-2 space-x-2" onclick="event.stopPropagation();">
                        <form action="{{ route('admin.pesanan.destroy', $menu->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-100 hover:bg-red-200 rounded-md transition">
                                Selesai
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- Modal --}}
{{-- Modal --}}
                <div id="modal-{{ $menu->id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
                    <div class="bg-white p-6 rounded-lg w-full max-w-lg">
                        <h3 class="text-xl font-bold mb-4">Detail Pesanan (ID: {{ $menu->id }})</h3>
                        <p><strong>Meja:</strong> {{ $menu->nomor_meja }}</p>
                        <p><strong>No. Telp:</strong> {{ $menu->nomor_hp }}</p>
                        <p class="mt-4 font-semibold">Daftar Menu:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($menu->detailPesanan as $detail)
                                <li>
                                    {{ $detail->nama_menu }} - {{ $detail->jumlah }} pcs 
                                    (Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }})
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-4 font-bold text-right">
                            Total: Rp {{ number_format($menu->detailPesanan->sum(fn($d) => $d->harga * $d->jumlah), 0, ',', '.') }}
                        </div>
                        <div class="mt-4 text-right">
                            <button onclick="hideModal({{ $menu->id }})" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Tutup</button>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Scripts --}}
<script>
    function showModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
        document.getElementById('modal-' + id).classList.add('flex');
    }

    function hideModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }
</script>
@endsection
