<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food4U | @yield('title')</title>

    <link rel="icon" type="image/png" href="/assets/img/pure-logo.png" sizes="190x104">

    @include('guest.layouts.css')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('css')
</head>

<body class="guest bg-nf-second">
    <div class="container py-6 px-5 mx-auto h-screen max-w-screen-2xl bg-nf-primary">
        @yield('content')
    </div>

    @yield('script')
    @include('guest.layouts.script')
</body>

</html>