<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food4U</title>
    @include('guest.layouts.css')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="guest bg-nf-second flex items-center justify-center min-h-screen">
    <div class="container w-full max-w-xs h-screen text-center bg-nf-primary">
        <div class="min-h-screen flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 text-white">
              <a href="/">
                <img src="assets/img/ic-back.png" alt="back" class="w-5 h-auto">
              </a>
              <h1 class="text-sm font-semibold">Keranjang</h1>
              <a class="opacity-0">
                ⬅️
              </a>
            </div>
          
            <!-- Nomor Meja -->
            <div class="bg-white py-2 px-4 flex justify-between items-center">
              <span class="text-gray-500 text-sm">Nomor Meja</span>
              <span class="text-green-500 font-bold text-sm">5</span>
            </div>
          
            <!-- Daftar Pesanan -->
            <div class="flex-1 overflow-y-auto">
                <span class="flex py-3 px-4">
                    <h2 class="text-orange-100 text-base font-semibold">Daftar Pesanan</h2>
                </span>
                <!-- Item Pesanan -->
                <div class="bg-white p-4 mb-4 flex items-center">
                    <img src="assets/img/nasi-goreng.png" alt="nasi-goreng" class="w-20 h-20 rounded-md object-cover mr-4">
                    <div class="flex-1">
                        <h3 class="text-gray-900 justify-start text-start font-semibold">Indomie Telor Special</h3>
                        <p class="text-gray-600 justify-start text-start text-sm">Rp. 50K</p>
                        
                        <div class="flex justify-between mt-3">
                            <div class="flex items-center w-fit rounded-md bg-yellow-600">
                                <button class="bg-yellow-600 text-white rounded-full w-6 h-6 flex items-center justify-center">
                                    <img src="assets/img/ic-minus.png" style="width: 60%">
                                </button>
                                <span class="mx-3 text-white text-sm font-semibold">5</span>
                                <button class="bg-yellow-700 text-white rounded-r-md w-6 h-6 flex items-center justify-center">
                                    <img src="assets/img/ic-plus.png" style="width: 60%">
                                </button>
                            </div>
                            <button class="ml-4">
                                <img src="assets/img/ic-trash.png" alt="trash" class="w-5 h-5">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
          
            <!-- Summary dan Tombol Pesan -->
            <div class="bg-yellow-600 p-4 text-sm rounded-t-2xl">
                <div class="flex justify-between text-white mb-2">
                    <span>Jumlah Item</span>
                    <span>10 Item</span>
                </div>
                <div class="flex justify-between text-white mb-4">
                    <span>Total Pesanan</span>
                    <span>Rp. 150K</span>
                </div>
                <a href="/checkout" class="block bg-white text-center text-black font-semibold py-3 rounded-full">
                    Pesan Sekarang
                </a>
            </div>
        </div>          
    </div>
</body>
</html>