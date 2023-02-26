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

<body style="font-size: 15px">
    <table>
        <thead></thead>
        <tbody>
            <tr>
                <td colspan="8" style="text-align: center; font-size:20px; font-weight: bold;">
                    <h3 class="text-center mb-3">
                        Laporan Transaksi Rental Playstation
                    </h3>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <p>Dari Tanggal: {{ $startDate }} Sampai: {{ $endDate }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th scope="col" style="font-weight:bold">ID Transaksi</th>
                <th scope="col" style="font-weight:bold">Nama</th>
                <th scope="col" style="font-weight:bold">Jenis Transaksi</th>
                <th scope="col" style="font-weight:bold">Nama Perangkat</th>
                <th scope="col" style="font-weight:bold">Jenis Playstation</th>
                <th scope="col" style="font-weight:bold">Lama Waktu</th>
                <th scope="col" style="font-weight:bold">Total</th>
                <th scope="col" style="font-weight:bold">Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaksi)
                <tr>
                    <td style="text-align: left">{{ $transaksi->id_transaksi }}</td>
                    @if ($transaksi->status === 'member')
                        <td>{{ $transaksi->member->nama }}</td>
                    @else
                        <td>{{ $transaksi->nama }}</td>
                    @endif
                    <td>{{ ucfirst($transaksi->status) }}</td>
                    <td>{{ $transaksi->device->nama }}</td>
                    <td>{{ $transaksi->device->playstation->nama }}</td>
                    <td>{{ $transaksi->jam_main . ' Jam' }}</td>
                    <td>{{ 'Rp ' . number_format($transaksi->total, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total: </td>
                <td colspan="7">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</td>
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
