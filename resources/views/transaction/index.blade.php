@extends('layouts.app')

@section('content')
    <!-- Content Row -->
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('gagal'))
        <div class="alert alert-danger col-lg-8" role="alert">
            {{ session('gagal') }}
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                Data Transaksi
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                </a>
                <a href="{{ route('transaction.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID Transaksi</th>
                        <th scope="col">Status</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis Playstation</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jam Main</th>
                        <th scope="col">Total</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Action</th>
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
                            <td>{{ $transaksi->playstation->nama }}</td>
                            <td>{{ 'Rp ' . number_format($transaksi->harga, 0, ',', '.') }}</td>
                            <td>{{ $transaksi->jam_main . ' Jam' }}</td>
                            <td>{{ 'Rp ' . number_format($transaksi->total, 0, ',', '.') }}</td>
                            <td>{{ $transaksi->created_at }}</td>
                            <td>
                                <form action="/transaction/{{ $transaksi->id_transaksi }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="border-0 bg-white" onclick="return confirm('Are you sure?')"><i
                                            class="fas fa-trash-alt text-danger"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $transactions->links() }}
        </div>
    </div>
    </div>
@endsection
