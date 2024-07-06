<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Sewa</title>
    <style>
        /* CSS styling for PDF */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 class="text-center">Laporan Transaksi Sewa Bulan {{ $month }} Tahun {{ $year }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Tanggal Pesanan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalTransaksi = 0;
            @endphp
            @foreach ($transaksi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->customer->name }}</td>
                    <td>{{ $item->product->nama_product }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>@rupiah($item->total)</td>
                    <td>{{ $item->tgl_pesanan }}</td>
                </tr>
                @php
                    $totalTransaksi += $item->total;
                @endphp
            @endforeach
            <tr>
                <th colspan="4">Total Transaksi</th>
                <td>@rupiah($totalTransaksi)</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
