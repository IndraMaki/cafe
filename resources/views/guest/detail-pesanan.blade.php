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

            <div class="text-white p-4 space-y-4 min-h-screen"> 

                @forelse ($pesanan as $p)
                    <div x-data="{ open: false }" class="bg-red-800 rounded-lg shadow-md border border-red-700 overflow-hidden"> {{-- Menggunakan warna merah untuk kartu --}}
                        <button @click="open = !open" class="flex justify-between items-center w-full p-5 cursor-pointer hover:bg-red-700 transition-colors duration-200">
                            <h3 class="text-l font-semibold text-red-200">Pesanan Meja {{ $p->nomor_meja }}</h3> {{-- Warna judul --}}
                            <span class="text-sm text-red-300">{{ $p->created_at->format('d M Y H:i') }}</span>
                            {{-- SVG icon untuk panah expand/collapse --}}
                            <svg :class="{'rotate-180': open}" class="w-6 h-6 transition-transform duration-200 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" x-collapse.duration.300ms class="border-t border-red-700 p-5 pt-0"> {{-- Tambahkan x-collapse untuk animasi --}}
                            <div class="mb-3 mt-4 space-y-1"> {{-- Margin atas setelah garis pemisah --}}
                                <p class="text-white"><strong class="font-bold text-red-300">Status:</strong> <span class="font-medium capitalize">{{ $p->status }}</span></p> {{-- Warna status --}}
                            </div>

                            <div>
                                <p class="font-bold text-red-300 mb-2">Detail Pesanan:</p>
                                <ul class="list-none space-y-2">
                                    @foreach ($p->detailPesanan as $detail)
                                        <li class="flex justify-between items-center text-white text-sm border-b border-red-700 pb-2 last:border-b-0 last:pb-0"> {{-- Warna item menu --}}
                                            <span>{{ $detail->nama_menu }} <span class="text-red-300">({{ $detail->jumlah }}x)</span></span> {{-- Warna jumlah --}}
                                            <span class="font-semibold text-red-100">Rp {{ number_format($detail->harga) }}</span> {{-- Warna harga --}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-red-800 rounded-lg shadow-md p-5 text-center text-red-300"> {{-- Warna untuk pesan kosong --}}
                        <p>Tidak ada pesanan ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
@endsection
