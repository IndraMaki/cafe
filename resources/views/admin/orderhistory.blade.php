@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-2xl font-semibold mb-3">Riwayat Pesanan</h2>

    <form method="GET" class="mb-4 flex items-center gap-2">
        <label for="tanggal_awal">Dari:</label>
        <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ request('tanggal_awal') }}"
            class="border rounded px-2 py-1" />

        <label for="tanggal_akhir">Sampai:</label>
        <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
            class="border rounded px-2 py-1" />

        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Cari</button>
    </form>

    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-300 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nomor Telp</th>
                    <th class="px-4 py-3 text-left">Total Harga</th>
                    <th class="px-4 py-3 text-left">Metode</th>

                    <th class="px-4 py-3 text-left">Cetak</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($menus as $menu)
                <tr class="bg-white hover:bg-gray-50 transition cursor-pointer"
                    onclick="openModal(this)"
                    data-nomorhp="{{ $menu->nomor_hp }}"
                    data-harga="Rp {{ number_format($menu->harga, 0, ',', '.') }}"
                    data-pesanan="{{ collect($menu->detailPesanan)->map(fn($d) => $d->nama_menu . ':' . number_format($d->harga * $d->jumlah, 0, ',', '.'))->implode(',') }}">
                    <td class="px-4 py-2">{{ $menu->id }}</td>
                    <td class="px-4 py-2">{{ $menu->nomor_hp }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $menu->metode_pembayaran }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.cetak.struk', $menu->id) }}" target="_blank"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                        Cetak
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada pesanan selesai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Pesanan -->
<div id="modalDetail" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-xl relative">
        <button onclick="closeModal()" class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl">&times;</button>
        <h3 class="text-lg font-bold mb-4">Detail Pesanan</h3>

        <p class="mb-2"><strong>Nomor HP:</strong> <span id="modalNomorHp"></span></p>
        
        <div class="mb-2">
            <strong>Pesanan:</strong>
            <div id="modalPesananList" class="mt-2 space-y-1">
                <!-- Daftar pesanan akan di-inject di sini -->
            </div>
        </div>
        
        <p class="mt-3"><strong>Total Harga:</strong> <span id="modalTotalHarga"></span></p>
    </div>
</div>

<script>
    function openModal(row) {
        document.getElementById('modalNomorHp').textContent = row.dataset.nomorhp;
        document.getElementById('modalTotalHarga').textContent = row.dataset.harga;

        const pesananList = document.getElementById('modalPesananList');
        pesananList.innerHTML = ''; // clear existing list

        const items = row.dataset.pesanan.split(',');

        items.forEach(item => {
            const [nama, harga] = item.split(':');
            const el = document.createElement('div');
            el.className = "flex justify-between";
            el.innerHTML = `<span>${nama}</span><span>Rp ${harga}</span>`;
            pesananList.appendChild(el);
        });

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalDetail').classList.add('hidden');
    }
</script>
@endsection
