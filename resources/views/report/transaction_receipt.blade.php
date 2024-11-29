<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Belanja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            max-width: 300px;
            margin: auto;
        }

        .title,
        .store-info {
            text-align: center;
            font-size: 11px;
        }

        .title {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info {
            text-align: left;
            margin-bottom: 20px;
        }

        .info div {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: none;
        }

        th,
        td {
            padding: 2px;
            text-align: left;
        }

        .right-align {
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="title">Struk Belanja</div>
    <div class="store-info">
        <div><strong>SMK Informatika Utama</strong></div>
        <div>PT.PLN P3B JAWA BALI NO.61 KRUKUT</div>
        <div>Telp: (021)753-0843 | Email: smki-utama@smki-gratis.sch.id</div>
    </div>

    <div class="info">
        <div><strong>ID Transaksi:</strong> {{ $transaction->transaction_id }}</div>
        <div><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</div>
        <div><strong>Nama Pelanggan:</strong> {{ $transaction->customer->customer_name ?? 'Umum' }}</div>
        <div><strong>Kasir:</strong> {{ $transaction->users->name ?? '-' }}</div>
        <div><strong>Metode Pembayaran:</strong> {{ $transaction->payment->payment_method ?? '-' }}</div>
    </div>

    <!-- Tabel Produk -->
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Price</th>
                <th class="right-align">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($transaction->details as $detail)
            <tr>
                <td>{{ $detail->product->product_name ?? 'Produk tidak ditemukan' }}</td>
                <td>Rp {{ number_format( $detail->product->price, 0, ',', '.')}}</td>
                <td>{{ $detail->quantity }}</td>
                <td class="right-align">Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
            </tr>
            @php $total += $detail->total; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td class="right-align"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td colspan="3">Diskon</td>
                <td class="right-align">Rp {{ number_format($transaction->discount ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Total Pembayaran</strong></td>
                <td class="right-align"><strong>Rp {{ number_format($total - ($transaction->discount ?? 0), 0, ',', '.')
                        }}</strong></td>
            </tr>
            <tr>
                <td colspan="3">Dibayar</td>
                <td class="right-align">Rp {{ number_format($transaction->payment->amount ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Kembalian</strong></td>
                <td class="right-align"><strong>Rp {{ number_format($transaction->payment->change, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Terima Kasih Telah Berbelanja!</p>
    </div>

</body>

</html>