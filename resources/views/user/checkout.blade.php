<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Checkout Pesanan</h2>

    <!-- Tampilkan Pesanan dalam Keranjang -->
    @if(session('cart') && count(session('cart')) > 0)
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $totalHarga = 0; @endphp
                @foreach(session('cart') as $id => $item)
                    @php $subtotal = $item['harga'] * $item['jumlah']; @endphp
                    <tr>
                        <td><img src="{{ asset('storage/' . $item['gambar']) }}" alt="{{ $item['nama'] }}" width="60"></td>
                        <td>{{ $item['nama'] }}</td>
                        <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @php $totalHarga += $subtotal; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total Harga:</th>
                    <th>Rp {{ number_format($totalHarga, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <!-- Form Checkout -->
        <form action="{{ route('pesanan.checkout') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nomor_meja" class="form-label">Nomor Meja</label>
                <input type="number" class="form-control" id="nomor_meja" name="nomor_meja" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Pesan</button>
        </form>
    @else
        <div class="alert alert-warning text-center">Keranjang masih kosong. <a href="{{ route('user.menu') }}">Kembali ke menu</a></div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
