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
    <h2>Struk Pesanan #{{ $pesanan->id }}</h2>
    <p>Nomor HP: {{ $pesanan->nomor_hp }}</p>
    <p>Metode Pembayaran: {{ $pesanan->metode_pembayaran }}</p>
    <p>Tanggal: {{ \Carbon\Carbon::parse($pesanan->updated_at)->format('d M Y H:i') }}</p>

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

    <h3>Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>
</body>
</html>
