@extends('guest.layouts.app')

@section('content')
<body class="guest bg-nf-second flex items-center justify-center min-h-screen">
    <div class="container w-full max-w-none h-screen text-center bg-nf-primary">
        <section class="py-40">
            <img src="/assets/img/logo-login.png" alt="Food4U Logo" class="w-40 mx-auto mb-4">

            <h1 class="text-5xl font-bold text-yellow-400">Food4U</h1>
            <p class="text-xs text-gray-300 mt-8">Special & Delicious food</p>
        </section>

        <form action="{{ route('guest.login.store') }}" method="POST">
            @csrf

            <input
                type="text"
                name="nomor_hp"
                placeholder="08xxxxxxxxxx"
                class="w-auto border-b border-gray-400 bg-transparent text-center text-gray-300 text-base tracking-widest focus:outline-none"
                required
                inputmode="numeric"
            >
            @if ($errors->has('nomor_hp'))
                <div class="text-red-500 text-sm mt-2">
                    {{ $errors->first('nomor_hp') }}
                </div>
            @endif

            <button type="submit" class="w-10/12 mt-6 bg-nf-sixth text-white text-base font-semibold py-2 rounded-full hover:bg-gray-700 transition">
                Submit
            </button>
        </form>
    </div>
</body>
@endsection
