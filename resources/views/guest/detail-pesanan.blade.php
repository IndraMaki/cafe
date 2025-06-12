@extends('guest.layouts.app')

@section('content')

<body class="guest bg-nf-second flex items-center justify-center min-h-screen">
    <div class="container w-full max-w-none text-center bg-nf-primary">
        <div class="min-h-screen flex flex-col">
            <div class="flex items-center justify-between p-4 text-white">
                <a href="/">
                    <img src="assets/img/ic-back.png" alt="back" class="w-5 h-auto">
                </a>
                <h1 class="text-sm font-semibold">Detail Pesanan</h1>
                <a class="opacity-0">⬅️</a>
            </div>

            <div class="text-gray-900 p-4 space-y-4 min-h-screen">

                @forelse ($pesanan as $p)
                    <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md border border-yellow-600 overflow-hidden"> 
                        <button @click="open = !open" class="flex justify-between items-center w-full p-5 cursor-pointer bg-yellow-500 hover:bg-yellow-600 transition-colors duration-200"> {{-- Ubah kembali ke yellow-500/600 untuk kecerahan yang konsisten --}}
                           
                            <h3 class="text-lg font-semibold text-gray-900">
                                @if ($p->status === 'pending')
                                    <span class="text-red-800 text-sm text-transform: capitalize">{{ $p->status }}</span> 
                                @elseif ($p->status === 'selesai')
                                    <span class="text-green-800 text-sm text-transform: capitalize">{{ $p->status }}</span> 
                                @else
                                    <span class="text-gray-700">{{ $p->status }}</span>
                                @endif
                            </h3>
                            <span class="text-sm text-gray-800">{{ $p->created_at->format('d M Y H:i') }}</span>
                            <svg :class="{'rotate-180': open}" class="w-6 h-6 transition-transform duration-200 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" x-collapse.duration.300ms class="border-t border-yellow-400 p-5 pt-0 text-gray-800">
                            <div>
                                <p class="font-semibold text-yellow-600 mb-2 text-sm text-left mt-2">Detail Pesanan:</p>
                                <hr class="border-yellow-400"> {{-- Tambahkan warna pada garis hr agar sesuai tema --}}
                                <ul class="list-none space-y-2 mt-2">
                                    @php
                                        $totalOrder = 0; // Inisialisasi total untuk setiap pesanan
                                    @endphp
                                    @foreach ($p->detailPesanan as $detail)
                                        <li class="flex justify-between items-center text-sm">
                                            <span>{{ $detail->nama_menu }} <span class="text-yellow-700">({{ $detail->jumlah }}x)</span></span>
                                            <span class="font-semibold text-yellow-800">Rp {{ number_format($detail->harga) }}</span>
                                        </li>
                                        @php
                                            $totalOrder += ($detail->harga * $detail->jumlah); // Hitung total
                                        @endphp
                                    @endforeach
                                </ul>
                                {{-- Bagian untuk menampilkan total --}}
                                <div class="mt-2 pt-2 border-t border-yellow-400 flex justify-between items-center">
                                    <p class="font-semibold text-sm">Total:</p>
                                    <p class="font-semibold text-sm text-yellow-800">Rp {{ number_format($totalOrder) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-md p-5 text-center text-gray-700 border border-yellow-400">
                        <p>Tidak ada pesanan ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
@endsection
