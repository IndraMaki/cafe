@extends('guest.layouts.app')

@section('content')
<div class="flex min-h-screen">
    <div class="flex flex-col px-4 justify-center items-center text-center mb-12">
        <h1 class="text-[#C29320] text-xl font-bold">Anda Telah Logout!</h1>
        <div class="flex flex-col items-center py-8">
            <img src="/assets/img/keluar.png" alt="Keluar" class="w-72 h-auto object-contain">
        </div>
        <p class="text-slate-50 text-sm mt-4 px-8">Untuk memesan kembali, silakan scan ulang QR Code di meja Anda.</p>
    </div>
</div>
@endsection
