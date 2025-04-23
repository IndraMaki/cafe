@extends('guest.layouts.app')

@section('content')
<div style="text-align: center; margin-top: 100px;">
    <h2>Anda telah logout</h2>
    <p>Untuk memesan kembali, silakan scan ulang QR Code di meja Anda.</p>
    <button onclick="window.close()" style="margin-top: 20px; padding: 10px 20px;">Tutup Halaman</button>
    <p style="margin-top: 10px; font-size: 14px; color: gray;">Jika halaman tidak bisa tertutup otomatis, silakan tutup tab ini secara manual.</p>
</div>
@endsection
