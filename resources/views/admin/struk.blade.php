<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border-bottom: 1px solid #ccc; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <p>Tanggal: {{ \Carbon\Carbon::parse($pesanan->updated_at)->format('d M Y H:i') }}</p>
    <h2>Struk Pesanan</h2>
    <p><strong>Order ID:</strong> {{ $pesanan->id }}</p>
    <p>Nomor HP: {{ $pesanan->nomor_hp }}</p>
    <p>Metode Pembayaran: {{ $pesanan->metode_pembayaran }}</p>

    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan->detailPesanan as $item)
            <tr>
                <td>{{ $item->nama_menu }}</td>
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (strtolower($pesanan->metode_pembayaran) === 'tunai')
        <p>Nominal Bayar: Rp {{ number_format($pesanan->nominal_bayar, 0, ',', '.') }}</p>
        <p>Total Harga: Rp {{ number_format($total, 0, ',', '.') }}</p>
        <p><strong>Kembalian: Rp {{ number_format($pesanan->nominal_bayar - $total, 0, ',', '.') }}</strong></p>
    @else
        <h3>Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>
    @endif
</body>
</html>
