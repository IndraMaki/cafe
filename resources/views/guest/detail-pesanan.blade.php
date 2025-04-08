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
            <div class="flex items-center justify-between p-4 text-white">
                <a href="/">
                  <img src="assets/img/ic-back.png" alt="back" class="w-5 h-auto">
                </a>
                <h1 class="text-sm font-semibold">Detail Pesanan</h1>
                <a class="opacity-0">
                  ⬅️
                </a>
              </div>
        </div>
    </div>
</body>
</html>