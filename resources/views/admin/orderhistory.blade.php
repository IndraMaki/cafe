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

        <button type="submit" class=" text-white px-3 py-1 rounded bg-yellow-500 hover:bg-yellow-600">Cari</button>
    </form>

    <div class="space-y-6"> 
        @forelse ($groupedPesanan as $date => $pesananPerTanggal)
            <div class="mb-4">
                {{-- Judul Tanggal --}}
                <h3 class="text-xl font-bold text-gray-800 mb-3 pb-2 border-b-2 border-gray-300">
                    Transaksi Tanggal {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                </h3>

                <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-300 text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Nomor Telp</th>
                                <th class="px-4 py-3 text-left">Total Harga</th>
                                <th class="px-4 py-3 text-left">Metode</th>
                                <th class="px-4 py-3 text-left">Waktu</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($pesananPerTanggal as $pesananItem) 
                                <tr class="bg-white hover:bg-gray-50 transition cursor-pointer"
                                    onclick="openModal(this)"
                                    data-nomorhp="{{ $pesananItem->nomor_hp }}"
                                    data-harga="Rp {{ number_format($pesananItem->harga, 0, ',', '.') }}"
                                    data-pesanan="{{ collect($pesananItem->detailPesanan)->map(fn($d) => $d->nama_menu . ':' . number_format($d->harga * $d->jumlah, 0, ',', '.'))->implode(',') }}">
                                    <td class="px-4 py-2">{{ $pesananItem->id }}</td>
                                    <td class="px-4 py-2">{{ $pesananItem->nomor_hp }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($pesananItem->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $pesananItem->metode_pembayaran }}</td>
                                    <td class="px-4 py-2">{{ $pesananItem->updated_at->format('H:i') }}</td>
                                    <td class="px-4 py-2 flex items-center gap-2">
                                        <a href="{{ route('admin.cetak.struk', $pesananItem->id) }}" target="_blank"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                        Cetak
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="text-center py-4 text-gray-500">
                <p>Belum ada pesanan ditemukan.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Detail Pesanan -->
<div id="modalDetail" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 transition-opacity duration-300 opacity-0 pointer-events-none">
    <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-2xl relative transform scale-95 transition-transform duration-300">
        
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-900 transition-colors duration-200 text-2xl font-semibold leading-none">&times;</button>
 
        <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b pb-3 border-gray-200">Detail Pesanan</h3>

        <div class="space-y-2 text-gray-700"> 
            <p class="text-lg"><strong>Nomor HP:</strong> <span id="modalNomorHp" class="font-medium text-gray-900"></span></p>
            
            <div>
                <p class="text-lg mb-2 font-bold">Pesanan:</p>
                <div id="modalPesananList" class="space-y-2 text-base">
                    </div>
            </div>
       
            <p class="text-xl pt-4 border-t border-gray-200"><strong>Total Harga:</strong> <span id="modalTotalHarga" class="font-bold text-green-600"></span></p>
        </div>
    </div>
</div>

<script>
    function openModal(row) {
        // Mengisi data ke dalam modal
        document.getElementById('modalNomorHp').textContent = row.dataset.nomorhp;
        document.getElementById('modalTotalHarga').textContent = row.dataset.harga;

        const pesananList = document.getElementById('modalPesananList');
        pesananList.innerHTML = ''; // Membersihkan daftar pesanan yang mungkin sudah ada

        const items = row.dataset.pesanan.split(',');

        items.forEach(item => {
            const [nama, harga] = item.split(':');
            const el = document.createElement('div');
            // Menambahkan kelas Tailwind CSS untuk styling setiap item pesanan
            el.className = "flex justify-between items-center py-1 border-b border-gray-100 last:border-b-0";
            el.innerHTML = `
                <span class="text-gray-800">${nama}</span>
                <span class="font-semibold text-gray-900">Rp ${harga}</span>
            `;
            pesananList.appendChild(el);
        });

        // Mengatur animasi modal saat dibuka
        const modal = document.getElementById('modalDetail');
        const modalContent = modal.querySelector('div'); // Mengambil div konten modal

        // Menghilangkan kelas hidden dan mengatur opacity/scale untuk transisi masuk
        modal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
        modalContent.classList.remove('scale-95'); // Hilangkan scale awal
        modalContent.classList.add('scale-100'); // Tambahkan scale penuh
        modal.classList.add('opacity-100'); // Atur opacity penuh
    }

    function closeModal() {
        const modal = document.getElementById('modalDetail');
        const modalContent = modal.querySelector('div'); // Mengambil div konten modal

        // Mengatur animasi modal saat ditutup
        modal.classList.remove('opacity-100'); // Mulai fade-out
        modalContent.classList.remove('scale-100'); // Mulai scale-out
        modalContent.classList.add('scale-95'); // Kembali ke scale awal

        // Sembunyikan modal sepenuhnya setelah transisi selesai
        modal.addEventListener('transitionend', function handler() {
            modal.classList.add('hidden', 'pointer-events-none');
            // Penting: Hapus event listener setelah digunakan agar tidak menumpuk
            modal.removeEventListener('transitionend', handler);
        });
    }
</script>
@endsection
