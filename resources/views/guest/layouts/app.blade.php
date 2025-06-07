<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food4U @yield('title')</title>

    <link rel="icon" type="image/png" href="/assets/img/pure-logo.png" sizes="190x104">

    @include('guest.layouts.css')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('css')
    <script src="https://cdn.tailwindcss.com"></script>   
</head>

<body class="guest bg-nf-second">
    <div class="container mx-auto max-w-screen-2xl min-h-screen bg-nf-primary relative"> 
        @yield('content')
    </div>

    @yield('script')
    @include('guest.layouts.script')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>