@extends('guest.layouts.app')

@section('content')

<body class="guest bg-nf-second flex items-center justify-center min-h-screen">
    <div class="container w-full max-w-none h-screen text-center bg-nf-primary">
        <div class="min-h-screen flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 text-white">
              <a href="/">
                <img src="{{ asset('assets/img/ic-back.png') }}" alt="back" class="w-5 h-auto">
              </a>
              <h1 class="text-sm font-semibold">Keranjang</h1>
              <a class="opacity-0">⬅️</a>
            </div>
          
            <!-- Nomor Meja -->
            <!-- <div class="bg-white py-2 px-4 flex justify-between items-center">
                <span class="text-gray-500 text-sm">Nomor Meja</span>
                <span class="text-green-500 font-bold text-sm">{{ session('nomor_meja') ?? '-' }}</span>
            </div> -->
            <div class="hidden bg-white py-2 px-4 flex justify-between items-center">
                <span class="text-gray-500 text-sm">Nomor HP</span>
                <span class="text-blue-500 font-bold text-sm">{{ session('nomor_hp') ?? '-' }}</span>
            </div>

          
            <!-- Daftar Pesanan -->
            <div class="flex-1 overflow-y-auto">
                <span class="flex py-3 px-4">
                    <h2 class="text-orange-100 text-base font-semibold">Daftar Pesanan</h2>
                </span>
                <!-- Item Pesanan -->
                @forelse ($cart as $id => $item)
                <div class="bg-white p-4 mb-4 flex items-center">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 rounded-md object-cover mr-4">
                    <div class="flex-1">
                        <h3 class="text-gray-900 justify-start text-start font-semibold">{{ $item['name'] }}</h3>
                        <p class="text-gray-600 justify-start text-start text-sm">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        
                        <div class="flex justify-between mt-3">
                            <div class="flex items-center w-fit rounded-md bg-yellow-600">
                                <!-- Button Minus -->
                                <button onclick="decreaseQuantity({{ $item['id'] }})" class="bg-yellow-600 text-white rounded-full w-6 h-6 flex items-center justify-center">
                                    <img src="{{ asset('assets/img/ic-minus.png') }}" style="width: 60%">
                                </button>

                                <span class="mx-3 text-white text-sm font-semibold">{{ $item['quantity'] }}</span>

                                <!-- Button Plus -->
                                <button onclick="increaseQuantity({{ $item['id'] }})" class="bg-yellow-700 text-white rounded-r-md w-6 h-6 flex items-center justify-center">
                                    <img src="{{ asset('assets/img/ic-plus.png') }}" style="width: 60%">
                                </button>
                            </div>

                            <button onclick="removeFromCart({{ $item['id'] }})" class="ml-4">
                                <img src="{{ asset('assets/img/ic-trash.png') }}" alt="trash" class="w-5 h-5">
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-white text-sm text-center">Belum ada pesanan</p>
                @endforelse
            </div>
          
            <!-- Summary dan Tombol Pesan -->
            <div class="bg-yellow-600 p-4 text-sm rounded-t-2xl">
                <div class="flex justify-between text-white mb-2">
                    <span>Jumlah Item</span>
                    <span>{{ $totalItems ?? 0 }} Item</span>
                </div>
                <div class="flex justify-between text-white mb-4">
                    <span>Total Pesanan</span>
                    <span>Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</span>
                </div>
                <p>Session nomor_hp: {{ session('nomor_hp') }}</p>
                <form action="{{ route('keranjang.pesan.midtrans') }}" method="POST">
                    @csrf
                    <!-- <input type="hidden" name="nomor_hp" value="{{ session('nomor_hp') }}"> -->
                    <button type="button" onclick="showPaymentOptions()" class="block w-full bg-white text-center text-black font-semibold py-3 rounded-full">
                        Pesan Sekarang
                    </button>

                    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
                        <div class="bg-white p-6 rounded-lg max-w-sm text-center space-y-4">
                            <h2 class="text-lg font-bold">Pilih Metode Pembayaran</h2>
                            <button type="button" onclick="bayarDiKasir()" class="w-full bg-gray-800 text-white py-2 rounded">Bayar di Kasir</button>
                            <button type="button" onclick="bayarOnline()" class="w-full bg-yellow-500 text-black py-2 rounded">Bayar Online</button>
                            <button type="button" onclick="closeModal()" class="text-sm text-gray-500 mt-2">Batal</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>          
    </div>
</body>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function showPaymentOptions() {
        document.getElementById('payment-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('payment-modal').classList.add('hidden');
    }

    function bayarDiKasir() {
        fetch("{{ route('keranjang.pesan') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        }).then(() => {
            window.location.href = "/done";
        });
    }

    function bayarOnline() {
        fetch("{{ route('keranjang.pesan.midtrans') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        }).then(response => response.json())
        .then(data => {
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    // Kirim order_id ke backend untuk simpan pesanan
                    fetch("{{ route('keranjang.pesanan.sukses') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ order_id: data.order_id })
                    }).then(() => {
                        window.location.href = "/done";
                    });
                },
                onPending: function(result) {
                    // Bisa juga dikirim kalau kamu mau catat pending
                    alert("Pembayaran pending.");
                },
                onError: function(result) {
                    alert("Pembayaran gagal.");
                },
                onClose: function() {
                    alert("Pembayaran dibatalkan.");
                }
            });
        });
    }

</script>
<script>
    function increaseQuantity(id) {
    fetch("{{ route('cart.increase') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload untuk update quantity
        }
    });
}

function decreaseQuantity(id) {
    fetch("{{ route('cart.decrease') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload untuk update quantity
        }
    });
}
function removeFromCart(id) {
    if (confirm("Apakah kamu yakin ingin menghapus item ini?")) {
        fetch("{{ route('cart.remove') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload untuk update keranjang
            }
        });
    }
}
</script>
@endsection