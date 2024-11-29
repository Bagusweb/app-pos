<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .header p {
            font-size: 16px;
            margin: 5px 0;
        }

        .date-range {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="header">
        <h1>Laporan Penjualan SMK Informatika Utama</h1>
        <p>JL. JCC KOMPLEKS PT.PLN P3B JAWA BALI NO.61 KRUKUT</p>
        <p><i>Telp: (021)753-0843 | Email: smki-utama@smki-gratis.sch.id</i></p>
    </div>
    <div class="date-range">Periode: {{ $tanggalBulanTahunawal }} - {{ $tanggalBulanTahunakhir }}</div>

    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Total Pembelian</th>
                <th>Diskon</th>
                <th>Total Pembayaran</th>
                <th>Metode Pembayaran</th>
                <th>Kembalian</th>
                <th>Kasir</th>
                <th>Detail Produk</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($transaction as $trans)
            <tr>
                <td>{{ $trans->transaction_id }}</td>
                <td>{{ $trans->payment->payment_date }}</td>
                <td>{{ $trans->customer->customer_name ?? '-' }}</td>
                <td>Rp {{ number_format($trans->total_amount, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($trans->discount, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($trans->payment->amount, 0, ',', '.') }}</td>
                <td>{{ $trans->payment->payment_method ?? '-' }}</td>
                <td>Rp {{ number_format($trans->payment->change, 0, ',', '.') }}</td>
                <td>{{ $trans->users->name ?? '-' }}</td>
                <td>
                    <ul>
                        @foreach ($trans->details as $detail)
                        <li>{{ $detail->product->product_name ?? 'Produk tidak ditemukan' }}<br>
                        - Harga: Rp {{ number_format($detail->product->price, 0, ',', '.')  }}<br>
                        - Jumlah: {{$detail->quantity }} <br>
                        - Subtotal: Rp {{ number_format($detail->total, 0, ',', '.') }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @php $grandTotal += $trans->total_amount; @endphp
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3" style="text-align: center;">Total Keseluruhan</td>
                <td colspan="7">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>

    </table>

</body>

</html>