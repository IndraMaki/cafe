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
        <div class="min-h-screen flex flex-col px-4 justify-center items-center text-center">
            <div>
                <div class="flex flex-col items-center">
                    <img src="/assets/img/done.png" alt="Sukses" class="w-44 h-44 object-contain">
                </div>
                <h1 class="text-[#C29320] text-xl font-bold mt-6">Pesanan Diterima</h1>
                <p class="text-white text-sm mt-4 px-2 mb-24 ">
                    Pesanan mu sudah diterima dan akan segera dipersiapkan, 
                    silahkan menunggu dengan santuy ya...
                </p>
                <div class="flex flex-col gap-3 px-6 w-full max-w-xs">
                    <a href="/detail-pesanan" class="bg-white text-base text-gray-800 py-2 rounded-md font-semibold">Lihat Pesanan</a>
                    <a href="/" class="bg-[#C29320] text-base text-white py-2 rounded-md font-semibold">Pesan Lainnya</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>