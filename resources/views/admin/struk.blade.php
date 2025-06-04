<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            width: 80mm;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .logo {
            width: 50mm;
            display: block;
            margin: 0 auto 5px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th, td {
            padding: 4px 0;
            text-align: left;
        }

        .total {
            font-weight: bold;
            margin-top: 5px;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .center {
            text-align: center;
        }
        .detail {
            display: flex;
            justify-content: space-between;
        }
        .detail p {
            margin-top: 3px;
            margin-bottom: 3px;
        }
        .detail1 {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ asset('assets/img/logo-login-admin.png') }}" alt="Logo" class="logo">
        <div class="center">
            <small>Tanggal: {{ \Carbon\Carbon::parse($pesanan->updated_at)->format('d M Y H:i') }}</small>
        </div>
        <h3 class="center">Struk Pesanan</h3>
    </div>

    <p><strong>Order ID:</strong> {{ $pesanan->id }}</p>
    <p><strong>Nomor HP:</strong> {{ $pesanan->nomor_hp }}</p>
    

    <hr>

    <table>
        <thead>
            <tr>
                <th colspan="2">Menu</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan->detailPesanan as $item)
            <tr>
                <td colspan="2">{{ $item->nama_menu }} (x{{ $item->jumlah }})</td>
                <td style="text-align: right;">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    

    <hr>
    <p><strong>Detail Transaksi</strong></p>
    @if (strtolower($pesanan->metode_pembayaran) === 'tunai')
    <div class="detail"> 
        <p>Total</p>
        <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
    </div>
    <div class="detail1"> 
        <p>Bayar</p>
        <p>Rp {{ number_format($pesanan->nominal_bayar, 0, ',', '.') }}</p>
    </div>
        
        <p class="total">Kembalian: Rp {{ number_format($pesanan->nominal_bayar - $total, 0, ',', '.') }}</p>
    @else
        <p class="total">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
    @endif

    <hr>

    <div class="center">
        <p>Terima kasih telah memesan!</p>
    </div>
</body>
</html>
