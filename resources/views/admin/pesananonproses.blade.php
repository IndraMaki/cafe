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
                    <th class="px-4 py-3 text-left">Nomor Telp</th>
                    <th class="px-4 py-3 text-left">Total Harga</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($menus as $menu)
                <tr class="bg-white hover:bg-gray-50 transition cursor-pointer" onclick="showPaymentModal({{ $menu->id }})">
                    <td class="px-4 py-2">{{ $menu->id }}</td>
                    <td class="px-4 py-2">{{ $menu->nomor_hp }}</td>
                    <td class="px-4 py-2">
                        Rp {{ number_format($menu->detailPesanan->sum(fn($d) => $d->harga * $d->jumlah), 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2">
                        <span class="text-yellow-600 font-semibold">Belum Bayar</span>
                    </td>
                    <td class="px-4 py-2 space-x-2" onclick="event.stopPropagation();">
                        <button type="button" onclick="showPaymentModal({{ $menu->id }})"
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-600 bg-green-100 hover:bg-green-200 rounded-md transition">
                            Selesai
                        </button>
                    </td>
                </tr>

                {{-- Modal Pembayaran dengan Detail Pesanan --}}
                <div id="payment-modal-{{ $menu->id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center px-4">
                    <div class="bg-white p-6 rounded-lg w-full max-w-lg max-h-[90vh] overflow-auto">
                        <h3 class="text-xl font-bold mb-4">Detail Pesanan (ID: {{ $menu->id }})</h3>

                        <p><strong>Meja:</strong> {{ $menu->nomor_meja }}</p>
                        <p><strong>No. Telp:</strong> {{ $menu->nomor_hp }}</p>

                        <div class="mt-4 font-semibold">Daftar Menu:</div>
                        <ul class="list-disc list-inside max-h-48 overflow-auto border border-gray-200 rounded p-2">
                            @foreach ($menu->detailPesanan as $detail)
                                <li>
                                    {{ $detail->nama_menu }} - {{ $detail->jumlah }} pcs 
                                    (Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }})
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-4 font-bold text-right text-lg">
                            Total: Rp {{ number_format($menu->detailPesanan->sum(fn($d) => $d->harga * $d->jumlah), 0, ',', '.') }}
                        </div>

                        <hr class="my-4">
                        <form action="{{ route('admin.pesanan.destroy', $menu->id) }}" method="POST" onsubmit="return validateTunaiInput({{ $menu->id }});">
                            @csrf
                            @method('DELETE')

                            <input type="hidden" name="metode_pembayaran" id="metode-{{ $menu->id }}">

                            <div class="flex flex-col space-y-3">
                                <button type="button" onclick="showTunaiInput({{ $menu->id }})"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tunai</button>

                                <input type="number" min="0" step="1000" id="uang-tunai-{{ $menu->id }}" name="uang_tunai" placeholder="Masukkan jumlah uang pelanggan" class="border border-gray-300 rounded px-3 py-2 mt-2 hidden" />

                                <button type="submit" onclick="setMetodePembayaran({{ $menu->id }}, 'Tunai')"
                                    class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 hidden" id="submit-tunai-{{ $menu->id }}">
                                    Bayar Tunai
                                </button>

                                <button type="submit" onclick="setMetodePembayaran({{ $menu->id }}, 'Debit')"
                                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Debit</button>
                            </div>

                            <div class="mt-4 text-right">
                                <button type="button" onclick="hidePaymentModal({{ $menu->id }})"
                                    class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Batal</button>
                            </div>
                        </form>

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
    function showPaymentModal(id) {
        const modal = document.getElementById('payment-modal-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hidePaymentModal(id) {
        const modal = document.getElementById('payment-modal-' + id);
        modal.classList.add('hidden');
        // Reset input dan metode pembayaran saat modal ditutup
        document.getElementById('metode-' + id).value = '';
        const inputUang = document.getElementById('uang-tunai-' + id);
        inputUang.value = '';
        inputUang.classList.add('hidden');

        const submitBtn = document.getElementById('submit-tunai-' + id);
        submitBtn.classList.add('hidden');
    }

    function setMetodePembayaran(id, metode) {
        const input = document.getElementById('metode-' + id);
        input.value = metode;
    }

    function showTunaiInput(id) {
        setMetodePembayaran(id, 'Tunai');

        const input = document.getElementById('uang-tunai-' + id);
        const submitBtn = document.getElementById('submit-tunai-' + id);

        input.classList.remove('hidden');
        submitBtn.classList.remove('hidden');
        input.focus();
    }

    function validateTunaiInput(id) {
        const metode = document.getElementById('metode-' + id).value;
        if (metode === 'Tunai') {
            const uangInput = document.getElementById('uang-tunai-' + id);
            const uang = parseInt(uangInput.value);

            if (!uang || uang <= 0) {
                alert('Mohon masukkan jumlah uang pelanggan yang valid.');
                uangInput.focus();
                return false; // batalkan submit
            }
        }
        return true;
    }
    setTimeout(() => {
        window.location.reload();
    }, 20000); // reload tiap 4 detik
</script>
@endsection
