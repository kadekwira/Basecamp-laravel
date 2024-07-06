<!DOCTYPE html>
<html>
<head>
    <title>Invoice Transaksi Sewa</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            background-color: #f6f6f6;
        }
        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header, .invoice-footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h2, .invoice-footer p {
            margin: 0;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details th, .invoice-details td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .invoice-details th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .invoice-summary {
            margin-top: 20px;
            text-align: right;
        }
        .invoice-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-summary th, .invoice-summary td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .invoice-summary th {
            background-color: #f2f2f2;
            text-align: right;
        }
        .invoice-summary td {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h2>Invoice Transaksi Sewa</h2>
        </div>
        <div class="invoice-details">
            <table>
                <tr>
                    <th>Customer</th>
                    <td>{{ $transaksi->customer->name }}</td>
                </tr>
                <tr>
                    <th>Product</th>
                    <td>{{ $transaksi->product->nama_product }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>{{ $transaksi->jumlah }}</td>
                </tr>
                <tr>
                    <th>Harga Product</th>
                    <td>@rupiah($transaksi->harga_product)</td>
                </tr>
                <tr>
                    <th>Harga Hilang</th>
                    <td>@rupiah($transaksi->harga_hilang)</td>
                </tr>
                <tr>
                    <th>Harga Telat</th>
                    <td>@rupiah($transaksi->harga_telat)</td>
                </tr>
                <tr>
                    <th>Harga Rusak</th>
                    <td>@rupiah($transaksi->harga_rusak)</td>
                </tr>
            </table>
        </div>
        <div class="invoice-summary">
            <table>
                <tr>
                    <th>Total</th>
                    <td>@rupiah($transaksi->total)</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $transaksi->status }}</td>
                </tr>
                <tr>
                    <th>Status Payment</th>
                    <td>{{ $transaksi->status_payment }}</td>
                </tr>
            </table>
        </div>
        <div class="invoice-footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
