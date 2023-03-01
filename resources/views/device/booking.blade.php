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
                Jadwal Booking {{ $device->nama }}
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                </a>

                <a href="/booking/{{ $device->id }}/add" class="btn btn-primary btn-sm">Booking</a>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Status</th>
                        <th scope="col">Jam Main</th>
                        <th scope="col">Waktu Mulai</th>
                        <th scope="col">Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <th scope="row">
                                {{ ($transactions->currentpage() - 1) * $transactions->perpage() + $loop->index + 1 }}</th>

                            @if ($transaction->status === 'member')
                                <td>{{ $transaction->member->user->name }}</td>
                            @else
                                <td>{{ $transaction->nama }}</td>
                            @endif
                            <td>{{ ucfirst($transaction->status) }}
                            </td>
                            <td>{{ $transaction->jam_main . ' Jam' }}</td>
                            <td>{{ $transaction->waktu_mulai }}</td>
                            <td>{{ $transaction->waktu_Selesai }}</td>

                            @if (auth()->user()->status === 'admin')
                                <a href="/device/{{ $device->id }}/edit"><i class="fas fa-edit"></i></a>
                                <form action="/device/{{ $device->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="border-0 bg-white" onclick="return confirm('Are you sure?')"><i
                                            class="fas fa-trash-alt text-danger"></i></button>
                                </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $transactions->links() }}
        </div>
    </div>
    </div>
@endsection
