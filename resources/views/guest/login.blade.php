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
        <section class="py-40">
            <img src="/assets/img/logo-login.png" alt="Food4U Logo" class="w-40 mx-auto mb-4">

            <h1 class="text-5xl font-bold text-yellow-400">Food4U</h1>
            <p class="text-xs text-gray-300 mt-8">Special & Delicious food</p>
        </section>
        <div class="mt-10 flex flex-col items-center">
            <input type="text" class="w-auto border-b border-gray-400 bg-transparent text-center text-gray-300 text-base tracking-widest focus:outline-none" placeholder="08xxxxxxxxx">

            <a href="/" class="w-10/12 mt-6 bg-nf-sixth text-white text-base font-semibold py-2 rounded-full hover:bg-gray-700 transition text-center block">
                Submit
            </a>            
        </div>
    </div>
</body>
</html>