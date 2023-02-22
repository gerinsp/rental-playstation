<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>
    <h3 class="text-center mb-3">
        Laporan Transaksi Rental Playstation
    </h3>
    <p class="mb-2">Dari Tanggal: {{ $starDate }} Sampai: {{ $endDate }}</p>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID Transaksi</th>
                <th scope="col">Status</th>
                <th scope="col">Nama</th>
                <th scope="col">Lama Waktu</th>
                <th scope="col">Total</th>
                <th scope="col">Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaksi)
                <tr>
                    <td>{{ $transaksi->id_transaksi }}
                    </td>
                    <td>{{ ucfirst($transaksi->status) }}
                    </td>
                    @if ($transaksi->status === 'member')
                        <td>{{ $transaksi->member->nama }}</td>
                    @else
                        <td>{{ $transaksi->nama }}</td>
                    @endif
                    <td>{{ $transaksi->jam_main . ' Jam' }}</td>
                    <td>{{ 'Rp ' . number_format($transaksi->total, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total: </td>
                <td colspan="5">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
