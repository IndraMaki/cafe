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

            <div class="text-left p-4 text-white space-y-4">
                @forelse ($pesanan as $p)
                    <div class="border-b pb-2">
                        <p><strong>Nomor Meja:</strong> {{ $p->nomor_meja }}</p>
                        <p><strong>Status:</strong> {{ $p->status }}</p>
                        <p><strong>Tanggal:</strong> {{ $p->created_at->format('d M Y H:i') }}</p>
                        <p><strong>Detail:</strong></p>
                        <ul class="ml-4 list-disc">
                            @foreach ($p->detailPesanan as $detail)
                                <li>{{ $detail->nama_menu }} - {{ $detail->jumlah }}x - Rp {{ number_format($detail->harga) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <p>Tidak ada pesanan ditemukan.</p>
                @endforelse
            </div>
        </div>
    </div>
</body>
@endsection
