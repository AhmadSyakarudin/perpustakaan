<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Peminjaman Buku</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        #receipt {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .header-title {
            font-size: 1.5rem;
            color: #007bff;
        }

        .back-button,
        .print-button {
            text-decoration: none;
            color: white;
        }

        .back-button:hover,
        .print-button:hover {
            color: white;
        }

        .table-bordered th,
        .table-bordered td {
            border-color: #dee2e6;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('pinjam.index') }}" class="btn btn-secondary back-button">Kembali</a>
        </div>

        <div class="card" id="receipt">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="header-title">Bukti Peminjaman Buku</h2>
                <a href="{{ route('pinjam.print.pdf', $order->id) }}" class="btn btn-primary print-button btn-sm">Cetak
                    (PDF)</a>
            </div>
            <div class="mb-4">
                <p>
                    <strong>Alamat Perpustakaan:</strong> Jl. Perpustakaan No. 123<br>
                    <strong>Email:</strong> perpustakaan@domain.com<br>
                    <strong>Phone:</strong> 0812-3456-7890
                </p>
            </div>

            <table class="table-bordered table">
                <thead class="thead-light">
                    <tr>
                        <th>Buku</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order['books'] as $book)
                        <tr>
                            <td>{{ $book['name'] }}</td>
                            <td>{{ $book['qty'] }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="1" class="text-right"><strong>Total Buku</strong></td>
                        <td>{{ $order['sum_book'] }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4 text-center">
                <p class="text-muted">Terima Kasih Atas Peminjaman Anda!</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
